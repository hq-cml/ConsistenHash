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
    
    $c_hash = new ConsistentHash();
    
    $c_hash->hash_add_slot('slot1');
    $c_hash->hash_add_slot('slot2');
    /*
    $c_hash->hash_add_slot('slot3');
    $c_hash->hash_add_slot('slot4');
    $c_hash->hash_add_slot('slot5');
    */
    
    echo "key1 in ".$c_hash->lookup('key1')."\n";
    echo "key2 in ".$c_hash->lookup('key2')."\n";
    echo "key3 in ".$c_hash->lookup('key3')."\n\n";
    
    $c_hash->hash_delete_slot('slot2');
    
    echo "key1 in ".$c_hash->lookup('key1')."\n";
    echo "key2 in ".$c_hash->lookup('key2')."\n";
    echo "key3 in ".$c_hash->lookup('key3')."\n\n";    
    
    $c_hash->hash_add_slot('slot6');
    
    echo "key1 in ".$c_hash->lookup('key1')."\n";
    echo "key2 in ".$c_hash->lookup('key2')."\n";
    echo "key3 in ".$c_hash->lookup('key3')."\n\n";  
    
