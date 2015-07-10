<?php
    class ConsistentHash
    {
        private $slots_arr = array();
        private $is_sorted = false;
        
        function my_hash($key)
        {
            return crc32($key);
        }
    }
    
