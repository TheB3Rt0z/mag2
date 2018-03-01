## i-ways Magento 2 Navigation Module

### Basics

- Create a Node by clicking on the "Create Parent" Button
    - If you want to associate a link with this Node, you can either:
        - Type it into the "link" input before you press the "Create Parent" Button
        - Change it afterwards by selecting the Node you want to change the link of, typing
          it into the link input and pressing the "Update" Button next to it
    - Links can be simple words directing to a subpage of your Website like "sale", which would result in:
      www.yourwebsite.com/sale.html
    - Or they can be URLs to external websites like "https://www.example.com/"
    - You can check and update the link at all times by selecting the Node again
- If you have a Parent Node selected, the "Parent Node" Button automatically changes into the
  "Create Child" Button. This Button lets you add as many Children to the selected Node as you want. Every Child can 
  have a link as well.
- Note: You can add Child Nodes to Nodes, that themselves are Children.
- The "Insert Categories" Button inserts all your Magento Categories, which have the "Include in Menu" Attribute set, 
  into your Tree. Pressing "c" on your Keyboard will do the same.
- Category Nodes can not be renamed, moved or deleted separately, but you can move your own nodes between them (but not 
  inside).
- If you have inserted the Categories you will notice, that the "Insert Categories" Button changed to the "Remove 
  Categories" Button. With this you can (as the Name suggests) remove all the Categories from your tree again.
- The Parent Nodes will appear as the main links in your Navbar. Child Nodes will turn up by hovering over their Parent.
- Add all your Magento-Store Categories as Nodes to the Tree by clicking on the "Category" Button.
- Category Nodes can not be moved or renamed, but you can add custom Nodes between the Category-Root Nodes.
- !Important: The tree is saved in the database only after you pressed the "Save Config" Button
      
### Controlls

- Insert Nodes by pressing the "Create Parent" or "Create Child" button or pressing "n" on your Keyboard.
- Rename Nodes by double clicking on them or selecting them and pressing F2. Nodes names can be up to 30 Characters long.
- Delete Nodes by either pressing the "Remove" Button or the "Del" Key on your Keyboard.
- Hover Nodes by hovering over them with your Mouse or by using the arrow keys.
    - Press up to go up, down to go down. Left and right will open/close Parent-Nodes. Select Nodes with the space bar.
- Deselect Nodes by clicking anywhere on the page except other Nodes or pressing the "Esc" Key on your Keyboard.
- Move the nodes freely by clicking on them and dragging them around.
- You can Delete and Move more than one Node at at a time by selecting multiple with the "Ctrl" Key on your Keyboard.
- Insert Categories by clicking on the "Insert Categories" Button or by pressing "c" on your Keyboard.
- Remove all Categories with the same Buttons.
- You can set the focus on the link input by pressing "l".
- Save the link by pressing "enter".
- If a yes/no question appears, you can also solve it by pressing "enter" for yes, or "esc" for no.
