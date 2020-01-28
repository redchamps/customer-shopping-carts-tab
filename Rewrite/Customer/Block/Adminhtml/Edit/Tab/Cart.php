<?php
namespace RedChamps\CustomerCarts\Rewrite\Customer\Block\Adminhtml\Edit\Tab;

use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Framework\Exception\NoSuchEntityException;

class Cart extends \Magento\Customer\Block\Adminhtml\Edit\Tab\Cart
{
    /**
     * Added fix when customer do not have any active quote
     * Magento 2 issue: https://github.com/magento/magento2/issues/26437
     * Pull request: https://github.com/magento/magento2/pull/26489
     */
    protected function _prepareCollection()
    {
        $quote = $this->getQuote();

        if ($quote && $quote->getId()) {
            $collection = $quote->getItemsCollection(false);
            $collection->addFieldToFilter('parent_item_id', ['null' => true]);
        } else {
            $collection = $this->_dataCollectionFactory->create();
        }

        $this->setCollection($collection);

        return Extended::_prepareCollection();
    }

    protected function getQuote()
    {
        if (null === $this->quote) {
            $customerId = $this->getCustomerId();
            $storeIds = $this->_storeManager->getWebsite($this->getWebsiteId())->getStoreIds();

            try {
                $this->quote = $this->quoteFactory->create()->setSharedStoreIds($storeIds)->loadByCustomer($customerId);
            } catch (NoSuchEntityException $e) {
                $this->quote = $this->quoteFactory->create()->setSharedStoreIds($storeIds);
            }
        }
        return $this->quote;
    }
}
