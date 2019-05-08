<?php

//require __DIR__ . '/vendor/autoload.php';

class ScheduleService 
{
    protected $repository;
    
    function __construct(ActivityRepository $activityRepository) 
    {
        $this->repository = $activityRepository;
    }
    
	public function plan($budget, $days): Schedule
	{
        $activities = $this->repository->getActivities($budget);

		return ScheduleFactory::fromActivities($activities, $days);
	}
}

interface ActivityRepository { 
   public function getActivities($budget); 
}  


class DatabaseActivityRepository implements ActivityRepository
{
    protected $database;
    
    public function __constructor(Database $database)
    {
        $this->database = $database;
    }
    
    function getActivities($budget)
    {
       // $repository = new Database($city);
        $activities = $this->database->getActivitiesByBudget($budget);
        
        return $activities;
        
    }
    
}

class ApiActivityRepository implements ActivityRepository
{
    protected $api;
    
    public function __constructor(Api $api)
    {
        $this->api = $api;
    }
    
    function getActivities($budget)
    {
       // $repository = new Database($city);
        $activities = $this->api->getActivitiesFromAPI($budget);
        
        return $activities;
        
    }
    
}

// data to test
$budget = 200;
$days = 4;
$city = 'berlin';

// map a city to an adapter string
$adaptersMap = ["berlin" => 'db', "tokyo" => 'db', "paris" => 'db', 'lisbon' => 'api', 'barcelona' => 'api', 'madrid' => 'api'];
// execute service
$adapter = $adaptersMap[$city];

if ($adapter === 'db') {
    $repository = new DatabaseRepository(new Database($city));    
} elseif ($adapter === 'api') {
    $repository = new ApiRepository(new Api($city));   
}

$service = new ScheduleService($repository);
$schedule = $service->plan($budget, $days);

print_r($schedule);