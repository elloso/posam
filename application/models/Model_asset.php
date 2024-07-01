<?php 

class Model_asset extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	
	public function getAssetData($asset_id = null)
	{
		if($asset_id) {
			$sql = "SELECT asset.*
		   FROM asset
		   WHERE asset_id = ?";
			$query = $this->db->query($sql, array($asset_id));
			return $query->row_array();
		}

		$sql = "SELECT asset.*
		FROM asset ORDER BY asset_name ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}



	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert('asset', $data);
			$asset_id = $this->db->insert_id();	
		return ($insert == true) ? $asset_id : false;
		}
	}



	public function update($asset_id, $data)
	{
		if($asset_id) {
         $this->db->where('asset_id', $asset_id);
			$update = $this->db->update('asset', $data);
			return ($update == true) ? true : false;
		}
	}
	

	public function remove($asset_id)
	{
		if($asset_id) {

			$this->db->where('asset_fk', $asset_id);
			$delete_document = $this->db->delete('document');

			$this->db->where('asset_fk', $asset_id);
			$delete = $this->db->delete('maintenance');

			$this->db->where('asset_id', $asset_id);
			$delete = $this->db->delete('asset');

			$path = "./upload/assets/".$asset_id;

			// Delete all the documents inside the directory
			// We can delete a directory with rmdir only if it's empty
			$dir = opendir($path);
		    while(false !== ( $file = readdir($dir)) ) {
		        if (( $file != '.' ) && ( $file != '..' )) {
		            $full = $path . '/' . $file;
		            if ( is_dir($full) ) {rrmdir($full);}
		            else {unlink($full);}
		        }
		    }
		    closedir($dir);
		    rmdir($path);

			return ($delete == true) ? true : false;

		}
	}

	public function countTotalAsset()
	{
		$sql = "SELECT * FROM asset";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}





//----------------------------------------- DOCUMENT --------------------------------------------------------------->


	public function getAssetDocument($asset_id)
	{

		$sql = "SELECT document.*
		FROM document 
		WHERE asset_fk = ?";
		$query = $this->db->query($sql, array($asset_id));
		return $query->result_array();
				

	}


	public function createDocument($data)
	{
		if($data) {
			$insert = $this->db->insert('document', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function removeDocument($document_id)
	{
		if($document_id) {
			$this->db->where('document_id', $document_id);
			$delete = $this->db->delete('document');
			return ($delete == true) ? true : false;
		}
	}

	public function getDocument($document_id = null)
	{
		$sql = "SELECT *
		FROM document
		WHERE document_id = ?";
		$query = $this->db->query($sql, array($document_id));
		return $query->row_array();

	}




}