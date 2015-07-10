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
        
        function hash_delete_slot($element)
        {
            $hash_value = $this->my_hash($element);
            
            if(!isset($this->slots_arr[$hash_value]))
            {
                unset($this->slots_arr[$hash_value]);
            }
            
            $this->is_sorted = false;
            return true; 
        }
        
        function lookup($key)
        {
            $hash_value = $this->my_hash($key);
            
            //°´keyÅÅÐò
            if(!$this->is_sorted)
            {
                krsort($this->slots_arr, SORT_NUMERIC);
                $this->is_sorted = true;
            }
            
            foreach($this->slots_arr as $pos=>$slot)
            {
                if($hash_value >= $pos)
                    return $slot;
            }
            
            return $this->slots_arr[count($this->slots_arr) - 1];
        }
    }
    
