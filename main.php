<?php

// main.php file

/**

*@param $activities [string in JSON format containing activities]
*@param $budget [Integer between 100 and 2000 inclusive]
*@param $days [Integer between 1 and 5]
*@return [string in JSON format containing the suggested schedule. ]

*/

function buildSchedule(string $activities, int $budget, int $days):string
{
  // implement me!
  $ac = json_decode(json_decode($activities));
    
      
  $activity_ids = [];
    
  $activity_durations = [];
    
  $activity_prices = [];
      
  $money_spent = 0;
  $time_spent = 0;
    
  if((!($days >= 1 and $days <= 5)) )
  {
      return  'Invalid days value. Days most be an integer value between [1,5]';
  }
  elseif($budget >= 100 and $budget <= 2000)
  {
      for($i=0;$i<count($ac);$i++)
      {
          $h = $budget - ($money_spent+$ac[$i]->price);
          if($h >= 0 )
          {
                array_push($activity_ids,$ac[$i]->id);
                array_push($activity_durations,$ac[$i]->duration);
                array_push($activity_prices,$ac[$i]->price);
                $money_spent+=$ac[$i]->price;
                $time_spent+=$ac[$i]->duration;
        
          }
      }
      
     
      
      $result['schedule']['summary']['budget_spent'] = $money_spent;
      
      $result['schedule']['summary']['time_spent'] = $time_spent;
      
      $j = 0; $current_budget = 0; 
          
      $activity_per_day = ceil(count($activity_ids)/$days);
      
      
  
      $days1 = $days;
      
      $current_activity_index= -1;
      $itinery_index =0;
      
      for($x=1;$x<=$days1;$x++){
         
          $start_time = '10:00';
          $h=0;
          
           //   $selectedTime = "9:15:00";
      for($i=$itinery_index;$i<count($activity_ids);$i++)
      {
          
          
            if((strtotime($start_time) >= strtotime('10:00')) ){
              
            if(!(strtotime($start_time) > strtotime('22:00')) ){
                
            
            $result['schedule']['days'][$x-1]['day'] = $x  ;
      
            $result['schedule']['days'][$x-1]['itinerary'][$h]['start'] = $start_time ;
      
            $result['schedule']['days'][$x-1]['itinerary'][$h]['activity']['id'] = $activity_ids[$i];
      
            $result['schedule']['days'][$x-1]['itinerary'][$h]['activity']['duration'] = $activity_durations[$i];
      
            $result['schedule']['days'][$x-1]['itinerary'][$h]['activity']['price'] = $activity_prices[$i];
           
            $activity_durations[$i]+=30;
          
            $start_time = date('H:i',strtotime("+".$activity_durations[$i]." minutes", strtotime($start_time)));
                
            
              
            $itinery_index++;
            $h++;
                
            }
          
           
            }
          
                                                        
      }
    }
      
  //  var_dump($time_p);
    return json_encode($result);  
      
  
      
  }
  else{
      return 'Sorry Budget must be an integer value between [100,2000]';
  }
      
  
 
  
    
 
  return $results;
}

$activities = json_encode(file_get_contents(__DIR__.'/' . $argv[1]),1);

$budget = $argv[2];

$days =  $argv[3];

echo buildSchedule($activities,$budget,$days);


?>