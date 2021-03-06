<?php

class Flagbit_MageHealth_Model_Resource_Quote extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Initialize resource
     *
     */
    public function _construct()
    {
        $this->_init('sales/quote', 'entity_id');
    }

    /**
     * clean Quotes
     *
     * @param $olderThan
     * @param int $limit
     * @return int
     */
     public function clean($olderThan, $limit = 5000)
     {
        $writeConnection = $this->_getWriteAdapter();

        $sql = sprintf('DELETE FROM %s WHERE updated_at < DATE_SUB(Now(), INTERVAL %s DAY) LIMIT %s',
           $writeConnection->quoteIdentifier($this->getMainTable(), true),
            max(intval($olderThan), 7),
            min(intval($limit), 50000)
        );

        $stmt = $writeConnection->query($sql);
        return $stmt->rowCount();
    }
}