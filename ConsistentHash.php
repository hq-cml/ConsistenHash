<?php
    class ConsistentHash
    {
        private $slots_arr = array();
        private $is_sorted = false;
        
        function my_hash($key)
        {
            return crc32($key);
        }
        function hash_add_slot($element)
        {
            $hash_value = $this->my_hash($element);
            echo $hash_value."\n";
            if(!isset($this->slots_arr[$hash_value]))
            {
                $this->slots_arr[$hash_value] = $element;
            }
            
            $this->is_sorted = false;
            return true;
        }
    }
    
