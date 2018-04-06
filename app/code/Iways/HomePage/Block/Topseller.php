<?php
/**
 * Created by PhpStorm.
 * User: gero
 * Date: 16.03.18
 * Time: 10:31
 */

namespace Iways\HomePage\Block;


use Magento\Framework\View\Element\Template;
use \Psr\Log\LoggerInterface;

class Topseller extends \Magento\Framework\View\Element\Template
{
    protected $homePageHelper;
    protected $logger;
    protected $storeManager;
    protected $currency;
    protected $productRepository;

    public function __construct(
        Template\Context $context,
        array $data = [],
        \Iways\HomePage\Helper\Data $homePageHelper,
        LoggerInterface $logger,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Model\Currency $currency,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    )
    {
        parent::__construct($context, $data);
        $this->homePageHelper = $homePageHelper;
        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->currency = $currency;
        $this->productRepository = $productRepository;
    }

    public function getImgSrc($product)
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) .
            'catalog/product' .
            $product->getImage();
    }

    public function getProductsById($idArray)
    {
        $products = array();
        for($i = 0; $i < count($idArray); $i++){
            try{
                $products[$i] = $this->productRepository->getById($idArray[$i]);
            }catch(\Magento\Framework\Exception\NoSuchEntityException $e){
                $this->logger->critical($e);
                $products[$i] = "";
            }
        }
        return $products;
    }

    public function getHotSellerIds()
    {
        $hotSellerIds = $this->homePageHelper->retrieveData();
        $hotSellerIds = $hotSellerIds['iways_homepage_settings']['hot_sellers'];

        return $hotSellerIds;
    }

    public function getPriceRender()
    {
        return $this->getLayout()->getBlock('product.price.render.default')
            ->setData('is_product_list', true);
    }

    public function buildPrice($product)
    {
        $priceRender = $this->getPriceRender();

        $price = '';
        if ($priceRender) {
            $price = $priceRender->render(
                \Magento\Catalog\Pricing\Price\FinalPrice::PRICE_CODE,
                $product,
                [
                    'include_container' => true,
                    'display_minimal_price' => true,
                    'zone' => \Magento\Framework\Pricing\Render::ZONE_ITEM_LIST,
                    'list_category_page' => true
                ]
            );
        }

        return $price;
    }

    public function renderTopSellerHtml()
    {
        $hotSellers = $this->getHotSellerIds();
        $products = $this->getProductsById(
            [
                $hotSellers["product_id_1"],
                $hotSellers["product_id_2"],
                $hotSellers["product_id_3"],
                $hotSellers["product_id_4"],
            ]
        );

        $html = "<div class=topseller-wrapper>";
        for($i = 0; $i < count($products); $i++){
            if(!empty($products[$i])){
                $html .=
                    '<div class="product-wrapper">'.
                        '<a href="' . $products[$i]->getUrlKey() . '.html">' .
                            '<div class="image-wrapper">' .
                                '<img class="topseller-image" src="' . $this->getImgSrc($products[$i]) . '" alt="Image">' .
                            '</div>' .
                            '<div class="topseller-text">' .
                                '<p class="topseller-name">' . $products[$i]->getName() . '</p>' .
                                '<p class="topseller-price">' . $this->buildPrice($products[$i]) . '</p>' .
                            '</div>' .
                        '</a>' .
                    '</div>';
            }else{
                $html .=
                    '<div class="product-wrapper">'.
                        '<div class="image-wrapper" style="background:#eeeeee;"></div>' .
                        '<div class="topseller-text">' .
                            '<p class="topseller-name">No Product specified!</p>' .
                        '</div>' .
                    '</div>';
            }
        }
        return $html .= '</div>';
    }
}