<?
class Count {
    protected $db,
    $htmlpath;
    public $page;
    function __construct($host,$user,$password,$db,$htmlpath) {
        $dsn = 'mysql:dbname='.$db.';host='.$host ;
        try{
            $this->db = new PDO($dsn, $user, $password);
        }catch (PDOException $e){
             return false;
        }
        $this->htmlpath = $htmlpath;
        return true;
    }
    //Get a name based off of the page loading it.
    public function getSuggestedName(){
        $filename = $_SERVER["SCRIPT_FILENAME"];
        $filename = str_replace(".php","",$filename);
        $filename = str_replace($this->htmlpath,"",$filename);
        $filename = str_replace("/","_",$filename);
        return $filename;
    }
    //Get the number of hits.
    public function getHits($Page = null){
        $Page = $Page;
        if($Page == null){
            $Page = $this->getSuggestedName();
        }elseif(strlen($Page) == 0){
            $Page = $this->getSuggestedName();
        }
        if ($getHitsQuery = $this->db->prepare("SELECT hitcount FROM hits WHERE page=:page")){
            $getHitsQuery->bindParam(':page', $Page);
            $getHitsQuery->execute();
            $results = $getHitsQuery->fetch(PDO::FETCH_ASSOC); 
            return $results['hitcount'];
        }else{
            return false;
        }
    }
    //Get reffering ip
    private function getUserIP(){
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }
        else{
            $ip = $remote;
        }

        return $ip;
    }
    //Check if the vistior has been here within the last week.
    private function hasVisited($Page){
        $Ref = $this->getUserIP();
        if(!filter_var($Ref, FILTER_VALIDATE_IP)){
            throw new Exception('Did not get valid ip');
            return;
        }
        if ($getVisted = $this->db->prepare("SELECT time_visted FROM history WHERE ip=:ip AND page=:page")){
            $getVisted->bindParam(':ip', $Ref);
            $getVisted->bindParam(':page', $Page);
            $getVisted->execute();
            $results = $getVisted->fetch(PDO::FETCH_ASSOC);
            $hits = $getVisted->rowCount();
            if($hits > 0){
                $stored = new DateTime($results['time_visted'] );
                $current = new DateTime();
                $diff = $current->diff($stored);
                $diff = abs($diff->format('%R%a'));
                if(7 <= $diff){
                    $delete = $this->db->prepare("DELETE FROM history WHERE ip=:ip AND page=:page");
                    $delete->bindParam(':ip', $Ref);
                    $delete->bindParam(':page', $Page);
                    $delete->execute();
                    return false;
                }else{
                    return true;
                }
            }else{
                return false;
            }
        }
        return false;
    }
    //Add a page hit.
    public function addHit($Page = null){
        if($Page == null){
            $Page = $this->getSuggestedName();
        }elseif(strlen($Page) == 0){
            $Page = $this->getSuggestedName();
        }
        $visited = $this->hasVisited($Page);
        if($visited === false){
            $currentCount = $this->db->prepare("SELECT hitcount FROM hits WHERE page=:page");
            $currentCount->bindParam(':page',$Page);
            $currentCount->execute();
            $found = $currentCount->rowCount();
            if($found > 0){
                $results = $currentCount->fetch(PDO::FETCH_ASSOC);
                $count = $results['hitcount'] + 1;
                $updateCount = $this->db->prepare("UPDATE hits SET hitcount=:count WHERE page=:page");
                $updateCount->bindParam(":count",$count);
                $updateCount->bindParam(":page",$Page);
                if(!$updateCount->execute()){
                    throw new Exception('Unable to update hits table!');
                }
                //Update history table to prevent someone from refreshing the page
                $addIPHistory = $this->db->prepare("INSERT INTO history (time_visted, ip, page) VALUES (:time, :ip, :page)");
                $addIPHistory->bindParam(":page",$Page);
				$IPaddr = $this->getUserIP();
                $addIPHistory->bindParam(":ip",$IPaddr);
                $time = new DateTime();
                $time = $time->format('Y-m-d');
                $addIPHistory->bindParam(":time",$time);
                if(!$addIPHistory->execute()){
                    throw new Exception('Unable to update history table!');
                }
                
            }else{
                
                //Update history table to prevent someone from refreshing the page
                $addIPHistory = $this->db->prepare("INSERT INTO history (time_visted, ip, page) VALUES (:time, :ip, :page)");
                $addIPHistory->bindParam(":page",$Page);
                $addIPHistory->bindParam(":ip",$this->getUserIP());
                $time = new DateTime();
                $time = $time->format('Y-m-d');
                $addIPHistory->bindParam(":time",$time);
                if(!$addIPHistory->execute()){
                    throw new Exception('Unable to update history table!');
                }
                //Create row in page table.
                $createPageRow = $this->db->prepare("INSERT INTO hits (page, hitcount) VALUES (:pages, 1)");
                $createPageRow->bindParam(":pages",$Page);
                if(!$createPageRow->execute()){
                    throw new Exception('Unable to insert new page into hits table!');
                }
                
            }
            
        }
    }
    
    
}