<?php
namespace RedChamps\CustomerCarts\Rewrite\Customer\Block\Adminhtml\Edit\Tab;

class Cart extends \Magento\Customer\Block\Adminhtml\Edit\Tab\Cart
{
    protected function getQuote()
    {
        if (null === $this->quote) {
            $customerId = $this->getCustomerId();
            $storeIds = $this->_storeManager->getWebsite($this->getWebsiteId())->getStoreIds();

            try {
                $this->quote = $this->quoteFactory->create()->setSharedStoreIds($storeIds)->loadByCustomer($customerId);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                $this->quote = $this->quoteFactory->create()->setSharedStoreIds($storeIds);
            }
        }
        return $this->quote;
    }
}