<?
defined('C5_EXECUTE') or die(_("Access Denied."));
Loader::model('file_list');
class DashboardFilesSearchController extends Controller {

	public function view() {
		$html = Loader::helper('html');
		$form = Loader::helper('form');
		$this->set('form', $form);
		$this->addHeaderItem($html->css('ccm.filemanager.css'));
		$this->addHeaderItem($html->javascript('ccm.filemanager.js'));
		$this->addHeaderItem('<script type="text/javascript">$(function() { ccm_activateFileManager(); });</script>');
		
		$ext1 = FileList::getExtensionList();
		$extensions = array();
		foreach($ext1 as $value) {
			$extensions[$value] = $value;
		}
		
		$t1 = FileList::getTypeList();
		$types = array();
		foreach($t1 as $value) {
			$types[$value] = FileType::getGenericTypeText($value);
		}
		
		$this->set('extensions', $extensions);		
		$this->set('types', $types);	
		
		$fileList = $this->getRequestedSearchResults();
		$files = $fileList->getPage();

		$this->set('fileList', $fileList);		
		$this->set('files', $files);		
		$this->set('pagination', $fileList->getPagination());
	}
	
	public function getRequestedSearchResults() {
		$fileList = new FileList();
		$keywords = htmlentities($_GET['fKeywords']);
		
		if ($keywords != '') {
			$fileList->filterByKeywords($keywords);
		}
		
		if (is_array($_REQUEST['fvSelectedField'])) {
			foreach($_REQUEST['fvSelectedField'] as $index => $item) {
				if ($item != '') {
					switch($item) {
						case "extension":
							$extension = $_REQUEST['extension'][$index];
							$fileList->filterByExtension($extension);
							break;
						case "type":
							$type = $_REQUEST['type'][$index];
							$fileList->filterByType($type);
							break;
						case "size":
							$from = $_REQUEST['size_from'][$index];
							$to = $_REQUEST['size_to'][$index];
							$fileList->filterBySize($from, $to);
							break;
						
					}
				}
			}
		}
		return $fileList;
	}
}

?>