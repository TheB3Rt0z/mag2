<?php
namespace Iways\Widgerama\Model;

use Iways\Widgerama\Helper\Encoder;
use \Magento\Widget\Model\Widget as BaseWidget;

class Widget
{
    const IW_IMAGE_IDENT = 'iw_media';

    /**
     * Fields to encode
     * @var []
     */
    protected $encodeFields = ['content', 'bottom_content'];

    protected $umlautFields = ['title', 'subtitle'];

    /**
     * Encodes string to widget compatiplity
     *
     * @var Encoder
     */
    protected $encoderHelper;

    /**
     * Widget constructor.
     * @param Encoder $encoderHelper
     */
    public function __construct(Encoder $encoderHelper)
    {
        $this->encoderHelper = $encoderHelper;
    }

    /**
     * Before Get Widget Declaration
     * @param BaseWidget $subject
     * @param string $type
     * @param [] $params
     * @param bool $asIs
     * @return array
     */
    public function beforeGetWidgetDeclaration(BaseWidget $subject, $type, $params = [], $asIs = true)
    {
        foreach ($params as $key => &$param) {
            if (in_array($key, $this->encodeFields)) {
                $param = $this->encoderHelper->encode($param);
                continue;
            }
            if (in_array($key, $this->umlautFields)) {
                $param = $this->encoderHelper->umlautify($param);
                continue;
            }
            if (strpos($key, self::IW_IMAGE_IDENT) !== false) {
                if (strpos($param, '/directive/___directive/') !== false) {
                    $parts = explode('/', $param);
                    $key = array_search("___directive", $parts);
                    if ($key !== false) {

                        $url = $parts[$key + 1];
                        $url = base64_decode(strtr($url, '-_,', '+/='));

                        $parts = explode('"', $url);
                        $key = array_search("{{media url=", $parts);
                        $url = $parts[$key + 1];
                        $param = $url;
                    }
                }
            }
        }
        return [$type, $params, $asIs];
    }
}