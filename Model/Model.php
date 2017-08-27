<?php
class Model{
	public $id;// private used for test var preservation
	public $title;
	public $description;
	public $severity;
	public $urgency;
	private $handler;// for connection

	function Model($connection=''){
	    if(!empty($connection)){
			$this->handler = $connection ;
		}
		else{
			$this->handler = new Connection();
		}
	}
		
// getters and setters
	public function setId($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}
	public function setTitle($title){
		$this->title = $title;
	}
	public function getTitle(){
		return $this->title;
	}
	public function setDescription($description){
		$this->description = $description;
	}
	public function getDesription(){
		return $this->description;
	}
	public function setSeverity($severity){
		$this->severity = $severity;
	}
	public function getSeverity(){
		return $this->severity;
	}
	public function setUrgency($urgency){
		$this->urgency = $urgency;
	}
	public function getUrgency(){
		return $this->urgency;
	}
	public function setStatus($status){
		$this->status = $status;
	}
	public function getStatus(){
		return $this->status;
	}
	
	public function create_one(){
       
       try{
        // 0/ connexion
$this->handler->beginTransaction();
        // 1/ query
        $query = "INSERT INTO issue SET title= :title, description = :description, severity = :severity, urgency = :urgency";
        // 2/ preparation
$stmt = $this->handler->prepare($query);
        // 3/ bind, $this-> in order to retrieve setter value
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':severity', $this->severity);
        $stmt->bindParam(':urgency', $this->urgency);
        if($stmt->execute()){
        $number=$stmt->rowCount();
            //echo "OK ".$number." traitment";
        }else{
            //die('KO 1st');
			return array('KO 1st');
        }  
        
        // 1/ query
        $query="INSERT INTO status SET id_issue=:id_issue, status=:status, date=:date";
        // 2/ preparation
$stmt = $this->handler->prepare($query);
        // 3/ bind
$id_issue=$this->handler->lastInsertId();//@todo verify
        $status=10;
        $date = date("YmdHis");//$date=20141006000000;
        $stmt->bindParam(':id_issue', $id_issue);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':date',$date);
        // replace
        if($stmt->execute()){
        $number=$stmt->rowCount();
			return array("OK ".$number." actions");
        }else{
            //die('KO 2nd');
			return array('KO 2nd');
        }        
        
$this->handler->commit();
    }catch(PDOException $exception){
$this->handler->rollback();
        //echo "Error: " . $exception->getMessage();
		return array("Error: " . $exception->getMessage());
    }
   // echo "create !";
     }
	
	public function retrieve_one(){// avoid param inside method
          try{
  
        // 0/ connexion
        // 1/ query
        
$query="SELECT i.id, i.title, i.description, i.severity, i.urgency";
$query.=", s.status, s.date";//, s.id as evenement sinon conflit entre id
$query.=" FROM issue i";
$query.=" JOIN status s";
$query.=" ON s.id_issue=i.id";
$query.=" WHERE s.id=(SELECT MAX(s.id) FROM status s WHERE s.id_issue=i.id)";// last status
$query.=" AND i.id=:id";        
        // 2/ étape préparation
        $stmt =$this->handler->prepare($query);// $con = $this->handler

        $stmt->setFetchMode(PDO::FETCH_ASSOC);// 
        // 3/ binder
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        // 4/ execution
        if($stmt->execute()){
        $number=$stmt->rowCount();
            //echo "OK ".$number." data found";
        }else{
			return array("die");
           // die('KO');// fait un return ?
			
        }  
  
     if($number>0)
     {  
        $result = $stmt->fetchAll();// fetch if one line
        /*echo '<pre>';
        print_r($result);
        echo '</pre>';*/
        return $result;
     }
     else{
        $result=array('nothing');
        return $result;
      }
            } 
            catch ( Exception $e ) {
              echo "error";
            }
      }
	
	public function update_one(){
      try{
        // 0/  connexion
$this->handler->beginTransaction();        
        // 1/ query
        $query = "UPDATE issue SET title= ?, description = ?, severity = ?, urgency = ? WHERE id = ?";
        // 2/ preparation
$stmt = $this->handler->prepare($query);
        // 3/ bind
        $stmt->bindParam(1, $this->title,PDO::PARAM_STR);
        $stmt->bindParam(2, $this->description,PDO::PARAM_STR);
        $stmt->bindParam(3, $this->severity,PDO::PARAM_INT);
        $stmt->bindParam(4, $this->urgency,PDO::PARAM_INT);
        $stmt->bindParam(5, $this->id,PDO::PARAM_INT);
        // 4/ execution
        if($stmt->execute()){// execute(array($resume,$description,$severite,$urgence,$id))
        $number=$stmt->rowCount();
            //echo "OK ".$number." data";
        }else{
            die('KO execution');
        }
        
        // is status changes
        if($this->status!=''){
            $query="INSERT INTO status SET id_issue=:id_issue, status=:status, date=:date";
            $date = date("YmdHis");
$stmt = $this->handler->prepare($query);
            $stmt->bindParam(':id_issue',$this->id,PDO::PARAM_INT);
            $stmt->bindParam(':status',$this->status,PDO::PARAM_INT);
            $stmt->bindParam(':date',$date);
            if($stmt->execute()){// execute(array($resume,$description,$severite,$urgence,$id))
                                $nombre=$stmt->rowCount();
                                    //echo "OK ".$nombre." traitement";
                                }else{
                                    die('KO update execution');
                                }
        }
        else{
            
        }
$this->handler->commit();        
    }catch(PDOException $exception){ //capture d'erreur
            echo "Erreur: " . $exception->getMessage();
        } 
      }// @todo $return=update update | with status
	
	public function delete_one(){//@todo add also delete all related id in status
          try{
        // 1/ query
        $sql = "DELETE FROM issue WHERE id =:id";
        // 2/ preparation
$stmt = $this->handler->prepare($sql);
        // 3/ bind
        $stmt->bindParam(':id', $this->id,PDO::PARAM_INT);//, PDO::PARAM_INT
        // 4/ execution
        if($stmt->execute()){
        $number=$stmt->rowCount();
		    if($number>0){			
            $result=array("OK ".$number." delete OK ");
			}
			else{
			$result=array("becareful ".$number." delete ! ");
			}           
        }else{
            $result=array("warning : die");
               //die('KO');
            }
    }catch(PDOException $exception){ //capture d'erreur
        $result=array("Error: " . $exception->getMessage());
    }  
		return $result;	
	}
}
?>