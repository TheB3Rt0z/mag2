<?php

namespace Iways\Navigation\Block\Adminhtml\Form\Field;


use Braintree\Exception;

class Tree extends \Magento\Config\Block\System\Config\Form\Field
{

    protected $_activation;
    protected $_categoryCollectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context  $context,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        array $data = []
    )
    {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get the Category Collection
     *
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection
     *
     */
    public function getCategoryCollection()
    {
        $collection = $this->_categoryCollectionFactory->create();
        try{
            $collection->addAttributeToSelect('*');
        }catch (\Exception $e){
        }
        return $collection;
    }

    /**
     * Build the Category Array
     *
     * @return array - All Magento-Categories and their Children
     */
    function getCategoryArray()
    {
        $categories = $this->getCategoryCollection();
        $arrayOutput = array();
        foreach ($categories as $category) {
            if ($category->toArray()["level"] == 1) {
                array_push($arrayOutput, $this->buildCategoryArray($category));
            }
        }
        return $arrayOutput;
    }

    /**
     * Recursively put one category and its children into an array
     *
     * @param $category
     * @return array - One Category and its Children
     */
    function buildCategoryArray($category)
    {
        $currentCategory = $category->toArray();
        if ($currentCategory["children_count"] > 0) {
            $childCount = -1;
            $childCategories = $category->getChildrenCategories();
            $childCategories->clear();
            $childCategories->addAttributeToSelect('include_in_menu');
            $childCategories->load();
            foreach ($childCategories as $childCategory) {
                $childCount++;
                $currentCategory["children"][$childCount] = $this->buildCategoryArray($childCategory);
            }
        }
        return $currentCategory;
    }

    /**
     * Render block HTML
     *
     * @return string
     * @throws \Exception
     */

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $categories = $this->getCategoryArray();
        $site = $element->getElementHtml();
        $site .=
            '<div id="treeButtons">
                <button type="button" class="button" id="createNode" data-bind="i18n: \'Create Parent\'"></button>
                <button type="button" class="button" id="insertCategory"></button>
                <button type="button" class="button" id="removeNode" data-bind="i18n: \'Remove\'"></button><br>
                <span id="treeSaveMessage"></span><br>
                <button type="button" class="button" id="enterDuplicateLink" data-bind="i18n: \'Yes\'"></button>
                <button type="button" class="button" id="dontEnterDuplicateLink" data-bind="i18n: \'No\'"></button><br>
                <input placeholder="Link" type="text" id="linkInput">
                <button type="button" class="button" id="updateLink" data-bind="i18n: \'Update\'"></button>
                <div id="saveWarning" data-bind="i18n: \'Unsaved!\'"></div>
                <div id="preventInput"></div>
            </div>
            <div id="treeDiv">
            </div>' .
            '<script>
            
            require(["jquery", "jstree", "mage/translate"],
                function($) {
                    //determines for what purpose the yes and no buttons where displayed (remove category nodes or insert node with duplicate link)
                    var choice = "";
                    //the story category collection
                    var categories = '. json_encode($categories) .';
                    //only children of default category are shown
                    categories = categories[0].children;
                    var jstreeDiv = $("#treeDiv");
                    var saveTextField = $("#navigation_test_frontend_navigation_links").hide();
                    var saveMessage = $("#treeSaveMessage").hide();
                    var nodeLink = $("#linkInput");
                    var insertCatButton = $("#insertCategory");
                    var yesButton = $("#enterDuplicateLink").hide();
                    var noButton = $("#dontEnterDuplicateLink").hide();
                    //the tree-data since the last magento-save
                    var startingTree = saveTextField.val();
                    //id the next created node is going to use
                    var nodeId = 0;
                    //the id of the selected node
                    var selectedNodeId = undefined;
                    //the link of the selected node
                    var selectedNodeLink = undefined;
                    //string of which node type should be created
                    var nodeType;
                    //true if a node with an already existing link should be created
                    var linkDuplicate = false;
                    //array of all the node-links used in the tree
                    var usedLinksArray = [];
                    
                    if(saveTextField.val() === ""){
                        saveTextField.val("[]");
                    }
                    
                    /**
                    Builds an array with all the Links currently in use
                    */
                    function linkUsed(json) {
                        for(var i = 0; i < json.length; i++){
                            if(json[i].metadata.link !== ""){
                                usedLinksArray.push(json[i].metadata.link); 
                            }                                                          
                            if(json[i].children !== undefined){
                                linkUsed(json[i].children);
                            }
                        }
                    }
                    
                    /**
                    disables or enables certain buttons
                    is called when a yes/no question is asked
                    */
                    function disableButtons(disable){
                        insertCatButton.prop("disabled",disable);
                        $("#createNode").prop("disabled",disable);
                        $("#removeNode").prop("disabled",disable);
                        $("#updateLink").prop("disabled",disable);
                        nodeLink.prop("disabled", disable);
                        if(disable){
                            if($(window).width() < 1417){
                                $("#preventInput").height(jstreeDiv.height() + 40).fadeIn(200);
                            }else{
                                $("#preventInput").height(jstreeDiv.height()).fadeIn(200);
                            }
                        }else{
                            $("#preventInput").fadeOut(200);
                        }
                    }
                    
                    /**
                    Creates Parent/Child Nodes or displays warning if the given link for the node already exists
                    */
                    function createNode(nodeName) {
                        if($(".jstree-clicked")[0] !== undefined){
                            var jqParent = $($(".jstree-clicked")[0].parentNode);
                            if(jqParent.hasClass("category-root") || jqParent.hasClass("category")){
                                saveMessage.html($.mage.__("You can\'t create a Child Node inside a Category Node!")).css("color", "red");
                                saveMessage.show().delay(2000).fadeOut();
                                return;
                            }
                        }
                        linkUsed(jstreeDiv.jstree("get_json", -1));
                        setHighestId(jstreeDiv.jstree("get_json", -1));
                        var nodeLinkText =  nodeLink.val();
                        if(!nodeLinkText.endsWith(".html") && nodeLinkText !== "" && !nodeLinkText.startsWith("http://")){
                            nodeLinkText += ".html";
                        }
                        if(($.inArray(nodeLinkText, usedLinksArray) === -1 || linkDuplicate) && nodeType !== "category"){
                            nodeLink.val(nodeLinkText);
                            if(nodeType === "parent"){
                                jstreeDiv.jstree("create", -1, "last", {attr: {id: "phtml-" + nodeId, class: "parent-node"},  data: nodeName , metadata: {"link": nodeLinkText}}, false, false);
                            }else if(nodeType === "child"){
                                jstreeDiv.jstree("create", null, "last", {attr: {id: "phtml-" + nodeId, class: "child-node"}, data: nodeName, metadata: {"link": nodeLinkText}}, false, false);
                            }
                        }else{
                             disableButtons(true);
                             saveMessage.html($.mage.__("You already have a node with this link, create anyways?")).css("color", "red");
                             saveMessage.fadeIn();
                             choice = "duplicate Link";
                             yesButton.fadeIn();
                             noButton.fadeIn();
                        }
                        usedLinksArray.length = 0;
                    }
                    '.'
                    
                    /**
                    createNode button handler
                    Calls createNode and determines if a child or parent node should be created
                    */
                    function createNodeHandler(){
                        if($(".jstree-clicked")[0] !== undefined){
                            var jqParent = $($(".jstree-clicked")[0].parentNode);
                            if(jqParent.hasClass("category-root") || jqParent.hasClass("category")){
                                saveMessage.html($.mage.__("You can\'t create a Child Node inside a Category Node!")).css("color", "red");
                                if(saveMessage.css("display") === "none"){
                                    saveMessage.fadeIn().delay(2000).fadeOut();
                                }
                            }else{
                                nodeType = "child";
                                createNode("new Child"); 
                            }
                        }else{
                            nodeType = "parent";
                            createNode("new Parent");
                        }
                    }
                    
                    /**
                    createNode button handler
                    Calls createNodeHandler
                    */
                    $("#createNode").click(function() {
                        createNodeHandler();                        
                    });
                    
                    /**
                    Determines if there are Category Nodes in the Tree and sets the Label of the Category Button
                    
                    @param json - json: the tree json
                    @param start - boolean: determines if the function was called when the page was loaded or by a click event
                    @return boolean - wether Category nodes exist or not
                    */
                    function categoriesExist(json, start){
                        for(var i = 0; i < json.length; i++){
                            if(json[i].attr.class === "category-root"){
                                if(start){
                                    insertCatButton.html($.mage.__("Remove Categories"));
                                }
                                return true;
                            }
                        }
                        if(start){
                            insertCatButton.html($.mage.__("Insert Categories"));
                        }else{
                            insertCatButton.html($.mage.__("Remove Categories"));
                        }
                        return false;
                    }
                    categoriesExist(JSON.parse(saveTextField.val()), true);              
                   
                    
                    /**
                    insertCategory button handler
                    calls categoryHandler
                    */
                    insertCatButton.click(function() {
                        categoryHandler();
                    });
                    
                    /**
                    inserts all child categories of the magento default category and their children into the tree
                    */
                    function categoryHandler(){
                        if(!categoriesExist(jstreeDiv.jstree("get_json", -1), false)){
                            for(var i = 0; i < categories.length; i++){
                                if(categories[i].include_in_menu === "1"){
                                    setHighestId(jstreeDiv.jstree("get_json", -1));
                                    jstreeDiv.jstree("create", -1, "last", {attr: {id: "phtml-" + nodeId, class: "category-root"}, data: categories[i].name, metadata: {"link": categories[i].request_path}}, false, true);
                                    if(categories[i].children_count > 0){
                                        insertChildCategories(categories[i].children, nodeId);
                                    }
                                }
                            }
                        autoSave(JSON.stringify(jstreeDiv.jstree("get_json", -1)));                   
                        }else{
                            disableButtons(true);
                            saveMessage.html($.mage.__("Do you really want to remove the Categories?")).css("color", "red");
                            saveMessage.fadeIn();
                            choice = "remove Categories";
                            yesButton.fadeIn();
                            noButton.fadeIn();
                        }
                    }
                                        
                    /**
                    recursively adds all children to a parent
                    */
                    function insertChildCategories(childCategory, parentId){
                        for(var j = 0; j < childCategory.length; j++){
                            if(childCategory[j].include_in_menu === "1"){
                                setHighestId(jstreeDiv.jstree("get_json", -1));
                                jstreeDiv.jstree("create", "#phtml-" + parentId, "last", {attr: {id: "phtml-" + nodeId, class: "category"}, data: childCategory[j].name, metadata: {"link": childCategory[j].request_path}}, false, true);
                                if(childCategory[j].children_count > 0){
                                    insertChildCategories(childCategory[j].children, nodeId);
                                }
                            }
                        }
                    }
                    
                    /**
                    checks if the selected node is not a category node and if not deletes it
                    else an error message is displayed
                    */
                    function removeNode(){
                        if($(".jstree-clicked")[0] !== undefined){
                            var jqParent = $($(".jstree-clicked")[0].parentNode);
                            if(jqParent.hasClass("category-root") || jqParent.hasClass("category")){
                                saveMessage.html($.mage.__("You can\'t remove a Category Node!")).css("color", "red");
                                if(saveMessage.css("display") === "none"){
                                    saveMessage.fadeIn().delay(2000).fadeOut();
                                }
                            }else{
                                jstreeDiv.jstree("remove");
                                deselectNodes();
                                autoSave(JSON.stringify(jstreeDiv.jstree("get_json", -1)));
                            }
                        }
                    }
                    
                    /**
                    removeNode button handler
                    Removes the currently selected node
                    */
                    $("#removeNode").click(function() {
                        removeNode();
                    });
                    
                    /**
                    yesButton/noButton button handler
                    calls yes/no functions;
                    */
                    yesButton.click(function() {yesFunc();});
                    noButton.click(function() {noFunc();});
                    
                    /**
                    Calls createNode and sets linkDuplicate to true, so a node with an already existing
                    link can be created anyways
                    if global variable choice is set to "remove Categories" it will continue to delete the category nodes
                    */
                    function yesFunc() {
                        if(choice === "duplicate Link"){
                            linkDuplicate = true;
                            createNode();
                            linkDuplicate = false;
                        }else if(choice === "remove Categories"){
                            insertCatButton.html($.mage.__("Insert Categories"));
                            jstreeDiv.jstree("remove", ".category-root");
                            deselectNodes();
                            autoSave(JSON.stringify(jstreeDiv.jstree("get_json", -1)));
                        }
                        saveMessage.fadeOut();
                        yesButton.fadeOut();
                        noButton.fadeOut();
                        choice = "";
                        disableButtons(false);
                    }
                    
                    /**
                    noButton button handler
                    The node with an already existing link is not created
                    if global variable choice is set to "remove Categories" it will just fade out the message and buttons
                    */
                    function noFunc() {
                        if(choice === "duplicate Link"){
                            linkDuplicate = false;
                        }
                        saveMessage.fadeOut();
                        yesButton.fadeOut();
                        noButton.fadeOut(); 
                        choice = "";
                        disableButtons(false);
                    }
                    
                    /**
                    updateLink button handler
                    Calls the update link function and displays info that the link has been updated 
                    or why it couldnt be updated                   
                    */
                    $("#updateLink").click(function() {
                        updateLinkHandler();
                    }); 
                    
                    function updateLinkHandler(){
                        if($(".jstree-clicked")[0] === undefined){
                            saveMessage.html($.mage.__("You need to select a Node to update a Link!")).css("color", "red");
                            if(saveMessage.css("display") === "none"){
                                saveMessage.fadeIn().delay(2000).fadeOut();
                            }
                        }else{
                            var jqParent = $($(".jstree-clicked")[0].parentNode);
                            if(jqParent.hasClass("category-root") || jqParent.hasClass("category")){
                                saveMessage.html($.mage.__("You can\'t change the link of a category Node!")).css("color", "red");
                                if(saveMessage.css("display") === "none"){
                                    saveMessage.fadeIn().delay(2000).fadeOut();
                                }
                            }else{
                                var jsonData = jstreeDiv.jstree("get_json", -1);
                                updateLink(jsonData);
                                autoSave(JSON.stringify(jsonData));
                                saveMessage.html($.mage.__("Link was updated!")).css("color", "green");
                                if(saveMessage.css("display") === "none"){
                                    saveMessage.fadeIn().delay(2000).fadeOut();
                                }
                            }
                        }
                    }
                    
                    /**
                    Enables double click on a node to rename it
                    Displays error if node is the category node
                    */
                    jstreeDiv.jstree("get_selected").dblclick(function() {
                        if(jstreeDiv.jstree("get_selected").length !== 0){
                            if(!yesButton.is(":visible")){
                                if(jstreeDiv.jstree("get_selected").hasClass("category") || jstreeDiv.jstree("get_selected").hasClass("category-root")){
                                    saveMessage.html($.mage.__("You can\'t rename a Category Node!")).css("color", "red");
                                    if(saveMessage.css("display") === "none"){
                                        saveMessage.fadeIn().delay(2000).fadeOut();
                                    }
                                }else{
                                    jstreeDiv.jstree("rename");
                                    $(".jstree-rename-input").attr("maxLength", 30);
                                } 
                            }
                        }
                    });  
                    
                    /**
                    deselect all nodes, reset the link-input and set the button text to create parent
                    */
                    function deselectNodes(){
                        jstreeDiv.jstree("deselect_all");
                        jstreeDiv.jstree("dehover_node");
                        if(!nodeLink.is(":disabled")){
                            nodeLink.val("");
                        }
                        $("#createNode").html($.mage.__("Create Parent"));
                    }
                    
                    /**
                    Enables deleting the currently selected nodes with the del key and
                    deselecting the selected nodes with the esc key                    
                    */
                    $("html").keyup(function(e) {
                        if(!yesButton.is(":visible") && !$(".jstree-rename-input")[0]){
                            if(!nodeLink.is(":focus")){
                                switch(e.keyCode){                                
                                    case 27: //esc
                                        deselectNodes();
                                        break;
                                    case 67: //c
                                        categoryHandler();
                                        break;
                                    case 76: //l
                                        nodeLink.focus();
                                        break;
                                    case 78: //n
                                        createNodeHandler();
                                        break;
                                }
                            }else if(e.keyCode === 13){ //enter
                                updateLinkHandler(); 
                            }
                        }else{
                            if(e.keyCode === 13){ //enter
                                yesFunc();
                            }else if(e.keyCode === 27){ //esc
                                noFunc();
                            }
                        }
                    });
                    
                    /**
                    checks if there was a click event on the window and if it was not on a node/button/input, the
                    selected nodes are unselected
                    */
                    $(window).click(function(event){
                        if(!yesButton.is(":visible")){
                            if($(event.target)[0].className.indexOf("jstree-clicked") < 0 && !$(event.target).is("button") && !$(event.target).is("input")){
                                deselectNodes();
                            }
                        }
                    });
                                       
                    /**
                    Gets the link of the currently selected node
                    */
                    function getLink(json) {
                        for(var i = 0; i < json.length; i++){
                            if(json[i].attr.id === selectedNodeId){
                                selectedNodeLink = json[i].metadata.link;
                            }
                            if(json[i].children !== undefined){
                                getLink(json[i].children);
                            }
                        }
                    }                    
                    
                    /**
                    Sets the link of the currently selected node to the value of the linkInput field
                    */
                    function updateLink(json) {
                        for(var i = 0; i < json.length; i++){
                            if(json[i].attr.id === selectedNodeId){  
                                var nodeLinkText =  nodeLink.val();
                                if(!nodeLinkText.endsWith(".html") && nodeLinkText !== "" && !nodeLinkText.startsWith("http://")){
                                    nodeLinkText += ".html";
                                }
                                json[i].metadata.link = nodeLinkText;
                                nodeLink.val(nodeLinkText);          
                            }
                            if(json[i].children !== undefined){
                                updateLink(json[i].children);
                            }
                        }
                    }
                    
                    /**
                    Searches for the highest id of any node and sets the global variable nodeId
                    to that value + 1
                    */
                    function setHighestId(json) {
                        if(json.length === 0){
                            nodeId = 0;
                        }else{
                            for(var i = 0; i < json.length; i++){
                                if(json[i].attr.id.substr(6) >= nodeId){                                    
                                    nodeId = parseInt(json[i].attr.id.substr(6)) + 1;
                                }                                                          
                                if(json[i].children !== undefined){
                                    setHighestId(json[i].children);
                                }
                            }
                        }                        
                    }
                    
                    /**
                    gets called whenever a change is made to the tree. Saves the tree and if the Tree
                    has changed since the last magento-save displays a save-warning.
                    
                    @param value - the json-string that should be saved in the saveTextField
                    */
                    function autoSave(value){
                        saveTextField.val(value);
                        if(startingTree !== saveTextField.val()){
                            $("#saveWarning").fadeIn(200);
                        }else{
                            $("#saveWarning").fadeOut(200);
                        }
                    }
                    
                    /**
                    Creates tree with various plugins from the json given in the magento textfield
                    */
                    jstreeDiv.jstree({
                        "json_data": {
                            "data": JSON.parse(saveTextField.val())
                        },
                        "plugins": [ "themes", "json_data", "ui", "crrm", "dnd", "types", "hotkeys"],
                        "crrm" : {
                            "move" : {
                                "check_move" : function(m){
                                    //trying to move a category node
                                    if($(m.o[0]).hasClass("category") || $(m.o[0]).hasClass("category-root")){
                                        return false;
                                    }
                                    //moving other nodes around the category nodes                                    
                                    if($(m.r[0]).hasClass("category")){
                                        return false;
                                    }
                                    if($(m.r[0]).hasClass("category-root")){
                                        if(m.p === "inside"){
                                            return false;
                                        }
                                    }
                                    return true;
                                }
                            }
                        },
                        "hotkeys":{
                            "del": 
                            function(){
                                if(!yesButton.is(":visible")){
                                    removeNode();
                                }
                            },
                            "f2": 
                            function(){
                                if(!yesButton.is(":visible")){
                                    if(jstreeDiv.jstree("get_selected").length !== 0){
                                        if(jstreeDiv.jstree("get_selected").hasClass("category") || jstreeDiv.jstree("get_selected").hasClass("category-root")){
                                            saveMessage.html($.mage.__("You can\'t rename a Category Node!")).css("color", "red");
                                            if(saveMessage.css("display") === "none"){
                                                saveMessage.fadeIn().delay(2000).fadeOut();
                                            }
                                        }else{
                                            jstreeDiv.jstree("rename");
                                        }
                                    }
                                }
                            },
                            "space":
                            function(){
                                if(!yesButton.is(":visible")){
                                    jstreeDiv.jstree("deselect_node", $(".jstree-clicked"));
                                    jstreeDiv.jstree("select_node", $(".jstree-hovered"));
                                }
                            }
                        }
                    })
                    /**
                    Event listener for if a node is renamed/moved/closed
                    saves the tree                   
                    */
                    .bind("rename.jstree move_node.jstree close_node.jstree", function(event, data){
                        autoSave(JSON.stringify(jstreeDiv.jstree("get_json", -1)));
                        
                    })
                    /**
                    Event listener for if a node is created/opened
                    saves the tree if it wasnt a category node
                    */
                    .bind("create.jstree open_node.jstree", function(event, data){
                        if(!data.rslt.obj.hasClass("category") && !data.rslt.obj.hasClass("category-root")){
                            autoSave(JSON.stringify(jstreeDiv.jstree("get_json", -1)));
                        }
                    })
                    /**
                    Event listener for if a node is selected
                    Sets global variable selectNodeId to the id of the selected node 
                    and the linkInput input field text to the link of that node                    
                    */
                    .bind("select_node.jstree", function(event, data) {
                        $("#createNode").html($.mage.__("Create Child"));
                        selectedNodeId = data.rslt.obj[0].id;
                        getLink(jstreeDiv.jstree("get_json", -1));
                        nodeLink.val(selectedNodeLink);
                    });  
                }  
                             
            );
            </script>';

        return $site;
    }

    protected function _renderValue(\Magento\Framework\Data\Form\Element\AbstractElement $element){
        $html = '<td class="value">';
        $html .= $this->_getElementHtml($element);
        $html .= '</td>';

        return $html;
    }

}