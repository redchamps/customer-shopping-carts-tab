<?php
namespace RedChamps\CustomerCarts\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;
use Magento\Ui\Component\Layout\Tabs\TabWrapper;
use RedChamps\CustomerCarts\Model\CustomerIdProvider;

/**
 * Class ShoppingCartsTab
 *
 * @package RedChamps\ShoppingCartsTab\Block\Adminhtml
 */
class ShoppingCartsTab extends TabWrapper
{
    /**
     * @var bool
     *
     * @var CustomerIdProvider
     */
    private $customerIdProvider;

    /**
     * @var bool
     */
    protected $isAjaxLoaded = true;

    /**
     * Constructor
     *
     * @param Context $context
     * @param CustomerIdProvider $customerIdProvider
     * @param array $data
     */
    public function __construct(Context $context, CustomerIdProvider $customerIdProvider, array $data = [])
    {
        $this->customerIdProvider = $customerIdProvider;
        parent::__construct($context, $data);
    }

    /**
     * @inheritdoc
     */
    public function canShowTab()
    {
        return $this->customerIdProvider->getCustomerId();
    }

    /**
     * Return Tab label
     *
     * @codeCoverageIgnore
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Shopping Cart');
    }

    /**
     * Return URL link to Tab content
     *
     * @return string
     */
    public function getTabUrl()
    {
        return $this->getUrl('customer/*/carts', ['_current' => true]);
    }
}
