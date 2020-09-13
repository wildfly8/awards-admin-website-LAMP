<?php

namespace Vonzo\Controllers;

class AdminController extends Controller {

    protected $account;

    public function index() {
      redirect('index');
    }

    public function add_nomination() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }

      $awardModel = $this->model('Award');
      $awardShowModel = $this->model('AwardShow');
      $awardShowYearModel = $this->model('AwardShowYear');

      if (isset($_GET['show_id'])) {
        $show_id = $_GET['show_id'];
        $data['award_show'] = $awardShowModel->getShowById($_GET['show_id']);
      } else {
        $data['award_show'] = false;
      }

      if (isset($_GET['show_year_id'])) {
        $show_year_id = $_GET['show_year_id'];
        $data['award_show_year'] = $awardShowYearModel->getShowYearById($_GET['show_year_id']);
      } else {
        $data['award_show_year'] = false;
      }

      if (isset($_GET['award_id'])) {
        $award_id = $_GET['award_id'];
        $data['award'] = $awardModel->getAwardById($_GET['award_id']);
      } else {
        $data['award'] = false;
      }

      $data['page_title'] = 'Add Nomination';
      $this->view->metadata['title'] = ['Add Nomination'];
      return ['content' => $this->view->render($data, 'admin/add/nomination')];
    }

    public function add_person() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      $data['page_title'] = 'Add Person';
      $this->view->metadata['title'] = ['Add Person'];
      return ['content' => $this->view->render($data, 'admin/add/person')];
    }
    public function add_project() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      $data['page_title'] = 'Add Project';
      $this->view->metadata['title'] = ['Add Project'];
      return ['content' => $this->view->render($data, 'admin/add/project')];
    }
    public function add_vendor() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      $data['page_title'] = 'Add Vendor';
      $this->view->metadata['title'] = ['Add Vendor'];
      return ['content' => $this->view->render($data, 'admin/add/vendor')];
    }
    public function add_studio() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      $data['page_title'] = 'Add Studio';
      $this->view->metadata['title'] = ['Add Studio'];
      return ['content' => $this->view->render($data, 'admin/add/studio')];
    }
    public function add_product() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      $data['page_title'] = 'Add Product';
      $this->view->metadata['title'] = ['Add Product'];
      return ['content' => $this->view->render($data, 'admin/add/product')];
    }
    public function add_network() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      $data['page_title'] = 'Add Network';
      $this->view->metadata['title'] = ['Add Network'];
      return ['content' => $this->view->render($data, 'admin/add/network')];
    }

		public function people_profile() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}
			$person_id = securityCheck($this->db, $this->url[2]);

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$peopleModel = $this->model('People');

			$xPerson = $peopleModel->doesPersonExistById($person_id);
			$data['profile'] = $peopleModel->getUserProfileById($xPerson, $awardModel, $awardShowModel, $awardShowYearModel);

			$data['page_title'] = $xPerson['full_name'] . ' Profile';
			$this->view->metadata['title'] = [$xPerson['full_name'] . ' Profile'];
			return ['content' => $this->view->render($data, 'admin/people_profile')];
		}

		public function projects_profile() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}
			$poject_id = securityCheck($this->db, $this->url[2]);

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$projectModel = $this->model('Project');

      $peopleModel = $this->model('People');
      $projectModel = $this->model('Project');
      $vendorModel = $this->model('Vendor');
      $studioModel = $this->model('Studio');

			$xProject = $projectModel->doesProjectExistById($poject_id);
			// $data['tv'] = $projectModel->getProjectTvsByProjectId($poject_id);
			$data['project'] = $projectModel->getProjectProfileById($xProject, $awardModel, $awardShowModel, $awardShowYearModel,$peopleModel,$projectModel,$vendorModel,$studioModel);

			$data['page_title'] = $xProject['title_name'] . ' Project Profile';
			$this->view->metadata['title'] = [$xProject['title_name'] . ' Project Profile'];
			return ['content' => $this->view->render($data, 'admin/projects_profile')];
		}

		public function vendors_profile() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}
			$vendor_id = securityCheck($this->db, $this->url[2]);

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$vendorModel = $this->model('Vendor');

			$xVendor = $vendorModel->doesVendorExistById($vendor_id);
			$data['vendor'] = $vendorModel->getVendorProfileById($xVendor, $awardModel, $awardShowModel, $awardShowYearModel);

			$data['page_title'] = $xVendor['company_name'] . ' Vendor Profile';
			$this->view->metadata['title'] = [$xVendor['company_name'] . ' Vendor Profile'];
			return ['content' => $this->view->render($data, 'admin/vendors_profile')];
		}

		public function studios_profile() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}
			$studio_id = securityCheck($this->db, $this->url[2]);

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$studioModel = $this->model('Studio');

			$xStudio = $studioModel->doesStudioExistById($studio_id);
			$data['studio'] = $studioModel->getStudioProfileById($xStudio, $awardModel, $awardShowModel, $awardShowYearModel);

			$data['page_title'] = $xStudio['company_name'] . ' Studio Profile';
			$this->view->metadata['title'] = [$xStudio['company_name'] . ' Studio Profile'];
			return ['content' => $this->view->render($data, 'admin/studios_profile')];
		}

		public function products_profile() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}
			$product_id = securityCheck($this->db, $this->url[2]);

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$productModel = $this->model('Product');

			$xProduct = $productModel->doesProductExistById($product_id);
			$data['product'] = $productModel->getProductProfileById($xProduct, $awardModel, $awardShowModel, $awardShowYearModel);

			$data['page_title'] = $xProduct['company_name'] . ' Product Profile';
			$this->view->metadata['title'] = [$xProduct['company_name'] . ' Product Profile'];
			return ['content' => $this->view->render($data, 'admin/products_profile')];
		}

		public function networks_profile() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}
			$network_id = securityCheck($this->db, $this->url[2]);

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$networkModel = $this->model('Network');

			$xNetwork = $networkModel->doesNetworkExistById($network_id);
			$data['network'] = $networkModel->getNetworkProfileById($xNetwork, $awardModel, $awardShowModel, $awardShowYearModel);

			$data['page_title'] = $xNetwork['company_name'] . ' Network Profile';
			$this->view->metadata['title'] = [$xNetwork['company_name'] . ' Network Profile'];
			return ['content' => $this->view->render($data, 'admin/networks_profile')];
		}

		public function departments_profile() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}
			$department_id = securityCheck($this->db, $this->url[2]);

			$data['page_title'] = 'Department Profile';
			$this->view->metadata['title'] = ['Department Profile'];
			return ['content' => $this->view->render($data, 'admin/departments_profile')];
		}




		public function media_viewer() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}
			$media_id = securityCheck($this->db, $this->url[2]);

			$peopleModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');
			$productModel = $this->model('Product');

			$mediaModel = $this->model('Media');
			$data['media'] = $mediaModel->getMediaById($media_id);

			$data['people'] = "None.";
      $data['projects'] = "None.";
      $data['studios'] = "None.";
      $data['vendors'] = "None.";
      $data['products'] = "None.";

      if ($data['media']['person_id'] != 0) {
        $xPerson = $peopleModel->doesPersonExistById($data['media']['person_id']);
        $data['people'] = '<a href="'.URL_PATH.'/admin/people/'.$xPerson['id'].'">'.$xPerson['full_name'].'</a>';
      }
      if ($data['media']['project_id'] != 0) {
        $xProject = $projectModel->doesProjectExistById($data['media']['project_id']);
        $data['projects'] = '<a href="'.URL_PATH.'/admin/projects/'.$xProject['id'].'">'.$xProject['title_name'].'</a>';
      }
      if ($data['media']['studio_id'] != 0) {
        $xStudio = $studioModel->doesStudioExistById($data['media']['studio_id']);
        $data['studios'] = '<a href="'.URL_PATH.'/admin/studios/'.$xStudio['id'].'">'.$xStudio['company_name'].'</a>';
      }
      if ($data['media']['vendor_id'] != 0) {
        $xVendor = $vendorModel->doesVendorExistById($data['media']['vendor_id']);
        $data['vendors'] = '<a href="'.URL_PATH.'/admin/vendors/'.$xVendor['id'].'">'.$xVendor['company_name'].'</a>';
      }
      if ($data['media']['product_id'] != 0) {
        $xProduct = $productModel->doesProductExistById($data['media']['product_id']);
        $data['products'] = '<a href="'.URL_PATH.'/admin/products/'.$xProduct['id'].'">'.$xProduct['company_name'].'</a>';
      }

			$data['page_title'] = 'Media Viewer #' . $media_id;
			$this->view->metadata['title'] = ['Media Viewer #' . $media_id];
			return ['content' => $this->view->render($data, 'admin/media_viewer')];
		}

		public function networks() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$peopleModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');
			$productModel = $this->model('Product');
			$networkModel = $this->model('Network');
			$departmentModel = $this->model('Department');
			$songModel = $this->model('Song');

			// $data['networks'] = $networkModel->listNetworks("", $awardModel, $awardShowModel);
			$searchModel = $this->model('Search');
			$data['networks'] = $searchModel->list("networks", $peopleModel, $projectModel, $vendorModel, $studioModel, $productModel, $networkModel, $departmentModel, $awardModel, $awardShowModel, $awardShowYearModel, $songModel);

			$data['page_title'] = 'Networks';
			$this->view->metadata['title'] = ['Networks'];
			return ['content' => $this->view->render($data, 'admin/networks')];

		}

		public function departments() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$peopleModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');
			$productModel = $this->model('Product');
			$networkModel = $this->model('Network');
			$departmentModel = $this->model('Department');
			$songModel = $this->model('Song');

			// $departmentModel = $this->model('Department');
			// $data['departments'] = $departmentModel->listDepartments("", $awardModel, $awardShowModel);

			$data['page_title'] = 'Departments';
			$this->view->metadata['title'] = ['Departments'];
			return ['content' => $this->view->render($data, 'admin/departments')];

		}

		public function media() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$peopleModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');
			$productModel = $this->model('Product');

			$mediaModel = $this->model('Media');
			$data['media'] = $mediaModel->listMedia($awardModel, $awardShowModel, $awardShowYearModel, $peopleModel, $projectModel, $vendorModel, $studioModel, $productModel);

			$data['page_title'] = 'Media';
			$this->view->metadata['title'] = ['Media'];
			return ['content' => $this->view->render($data, 'admin/media')];

		}

		public function songs() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$peopleModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');
			$productModel = $this->model('Product');
			$networkModel = $this->model('Network');
			$departmentModel = $this->model('Department');
			$songModel = $this->model('Song');

			$data['songs'] = $songModel->listSongs($awardModel, $awardShowModel, $awardShowYearModel);
			// $searchModel = $this->model('Search');
			// $data['songs'] = $searchModel->list("songs", $peopleModel, $projectModel, $vendorModel, $studioModel, $productModel, $networkModel, $departmentModel, $awardModel, $awardShowModel, $awardShowYearModel, $songModel);

			$data['page_title'] = 'Songs';
			$this->view->metadata['title'] = ['Songs'];
			return ['content' => $this->view->render($data, 'admin/songs')];

		}

		public function products() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$peopleModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');
			$productModel = $this->model('Product');
			$networkModel = $this->model('Network');
			$departmentModel = $this->model('Department');
			$songModel = $this->model('Song');

			// $data['products'] = $productModel->listProducts("", $awardModel, $awardShowModel);
			$searchModel = $this->model('Search');
			$data['products'] = $searchModel->list("products", $peopleModel, $projectModel, $vendorModel, $studioModel, $productModel, $networkModel, $departmentModel, $awardModel, $awardShowModel, $awardShowYearModel, $songModel);

			$data['page_title'] = 'Products';
			$this->view->metadata['title'] = ['Products'];
			return ['content' => $this->view->render($data, 'admin/products')];

		}

		public function studios() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$peopleModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');
			$productModel = $this->model('Product');
			$networkModel = $this->model('Network');
			$departmentModel = $this->model('Department');
			$songModel = $this->model('Song');

			// $data['studios'] = $studioModel->listStudios("", $awardModel, $awardShowModel);
			$searchModel = $this->model('Search');
			$data['studios'] = $searchModel->list("studios", $peopleModel, $projectModel, $vendorModel, $studioModel, $productModel, $networkModel, $departmentModel, $awardModel, $awardShowModel, $awardShowYearModel, $songModel);

			$data['page_title'] = 'Studios';
			$this->view->metadata['title'] = ['Studios'];
			return ['content' => $this->view->render($data, 'admin/studios')];

		}

		public function vendors() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$peopleModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');
			$productModel = $this->model('Product');
			$networkModel = $this->model('Network');
			$departmentModel = $this->model('Department');
			$songModel = $this->model('Song');

			// $data['vendors'] = $vendorModel->listVendors("", $awardModel, $awardShowModel);
			$searchModel = $this->model('Search');
			$data['vendors'] = $searchModel->list("vendors", $peopleModel, $projectModel, $vendorModel, $studioModel, $productModel, $networkModel, $departmentModel, $awardModel, $awardShowModel, $awardShowYearModel, $songModel);

			$data['page_title'] = 'Vendors';
			$this->view->metadata['title'] = ['Vendors'];
			return ['content' => $this->view->render($data, 'admin/vendors')];

		}

		public function projects() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$peopleModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');
			$productModel = $this->model('Product');
			$networkModel = $this->model('Network');
			$departmentModel = $this->model('Department');
			$songModel = $this->model('Song');

			// $data['projects'] = $projectModel->listProjects("", $awardModel, $awardShowModel);
			$searchModel = $this->model('Search');
			$data['projects'] = $searchModel->list("projects", $peopleModel, $projectModel, $vendorModel, $studioModel, $productModel, $networkModel, $departmentModel, $awardModel, $awardShowModel, $awardShowYearModel, $songModel);

			$data['page_title'] = 'Projects';
			$this->view->metadata['title'] = ['Projects'];
			return ['content' => $this->view->render($data, 'admin/projects')];

		}

		public function people() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');
			$peopleModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');
			$productModel = $this->model('Product');
			$networkModel = $this->model('Network');
			$departmentModel = $this->model('Department');
			$songModel = $this->model('Song');

			$searchModel = $this->model('Search');
			$data['people'] = $searchModel->list("people", $peopleModel, $projectModel, $vendorModel, $studioModel, $productModel, $networkModel, $departmentModel, $awardModel, $awardShowModel, $awardShowYearModel, $songModel);
			// $data['people'] = $peopleModel->listPeople($awardModel, $awardShowModel, $awardShowYearModel);

			$data['page_title'] = 'People';
			$this->view->metadata['title'] = ['People'];
			return ['content' => $this->view->render($data, 'admin/people')];

		}

		public function show_year_noms_edit() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}
			$show_id = securityCheck($this->db, $this->url[2]);
			$show_year_id = securityCheck($this->db, $this->url[3]);
			$award_id = securityCheck($this->db, $this->url[4]);
			$nomination_id = securityCheck($this->db, $this->url[5]);

			$awardShowModel = $this->model('AwardShow');
			$data['show'] = $awardShowModel->getShowById($show_id);

			$awardShowYearModel = $this->model('AwardShowYear');
			$data['show_year'] = $awardShowYearModel->getShowYearById($show_year_id);

			$awardModel = $this->model('Award');
			$data['award'] = $awardModel->getAwardById($award_id);
			error_log("HERE");

			$personModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');
			$networkModel = $this->model('Network');
			$productModel = $this->model('Product');
			$nominationModel = $this->model('Nomination');
			$data['nominees'] = $nominationModel->getNominationPage($productModel, $networkModel, $personModel, $projectModel, $vendorModel, $studioModel, $data['award'], $data['show'], $nomination_id, $show_id, $show_year_id, $data['show_year']['year_existing']);

			$data['page_title'] = $data['award']['name'] . ' for ' . $data['show_year']['year_existing'] . ' ' . $data['show']['full_name'];
			$this->view->metadata['title'] = [$data['award']['name'] . ' for ' . $data['show_year']['year_existing'] . ' ' . $data['show']['full_name']];
			return ['content' => $this->view->render($data, 'admin/show_year_noms_edit')];
		}

		public function show_year_noms() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}
			$show_id = securityCheck($this->db, $this->url[2]);
			$show_year_id = securityCheck($this->db, $this->url[3]);
			$award_id = securityCheck($this->db, $this->url[4]);
      if (isset($_GET['nexty'])) {
		     $nexty = securityCheck($this->db, $_GET['nexty']);
       } else {
         $nexty = "";
       }

			$awardShowModel = $this->model('AwardShow');
			$data['show'] = $awardShowModel->getShowById($show_id);

			$awardShowYearModel = $this->model('AwardShowYear');
			$data['show_year'] = $awardShowYearModel->getShowYearById($show_year_id);

			$awardModel = $this->model('Award');
			$data['award'] = $awardModel->getAwardById($award_id);

			$personModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');

			$data['nominees'] = $awardShowYearModel->getNomineesPage($personModel, $projectModel, $vendorModel, $studioModel, $data['award'], $data['show'], $data['show_year']['id'], $show_id, $data['show_year']['year_existing'], $award_id, false);

			$data['page_title'] = $data['award']['name'] . ' for ' . $data['show_year']['year_existing'] . ' ' . $data['show']['full_name'];
			$this->view->metadata['title'] = [$data['award']['name'] . ' for ' . $data['show_year']['year_existing'] . ' ' . $data['show']['full_name']];
			return ['content' => $this->view->render($data, 'admin/show_year_noms')];

		}

		public function show_year() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}
			$show_id = securityCheck($this->db, $this->url[2]);
			$show_year_id = securityCheck($this->db, $this->url[3]);

			$awardShowModel = $this->model('AwardShow');
			$data['show'] = $awardShowModel->getShowById($show_id);

			$awardShowYearModel = $this->model('AwardShowYear');
			$data['show_year'] = $awardShowYearModel->getShowYearById($show_year_id);

			$networkModel = $this->model('Network');
			$data['networks'] = $networkModel->getAllNetworks();

			$awardModel = $this->model('Award');
			$data['listAwardsChecklist'] = $awardModel->listAwardCheckboxesByAwardIdByArray($data['show']['awards_array'], $data['show_year']['this_years_awards_id_array']);

			$notesModel = $this->model('Notes');
			$data['theInternalNotes'] = $notesModel->getInternalNotes("award_show_year", $data['show_year']['id']);

			$personModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');

			$categoriesThisYearFetch = $awardShowYearModel->listAwardsInShowYearFromArray($personModel, $projectModel, $vendorModel, $studioModel, $awardModel, $data['show'], $show_id, $show_year_id, $data['show_year']['year_existing'], $data['show_year']['this_years_awards_id_array'], false); // summary = false
			$data['category_count'] = $categoriesThisYearFetch[1];
			$data['nom_count'] = $categoriesThisYearFetch[2];
			$data['winner_count'] = $categoriesThisYearFetch[3];
			$data['categoriesThisYear'] = $categoriesThisYearFetch[0];
      // error_log(print_r($data['categoriesThisYear'], true));

			$data['page_title'] = $data['show_year']['year_existing'] . ' ' . $data['show']['full_name'];
			$this->view->metadata['title'] = [$data['show_year']['year_existing'] . ' ' . $data['show']['full_name']];
			return ['content' => $this->view->render($data, 'admin/show_year')];
		}

		public function show_category() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}
			$show_id = securityCheck($this->db, $this->url[2]);
			$award_id = securityCheck($this->db, $this->url[3]);

			$awardModel = $this->model('Award');
			$awardShowModel = $this->model('AwardShow');
			$awardShowYearModel = $this->model('AwardShowYear');

			$data['show'] = $awardShowModel->getShowById($show_id);
			$data['award'] = $awardModel->getAwardById($award_id);

			$personModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');

			$data['awards'] = $awardShowYearModel->getNomineesPage($personModel, $projectModel, $vendorModel, $studioModel, $data['award'], $data['show'], 0 ,$show_id, 0, $award_id, false); // winner = false

			$data['page_title'] = $data['show']['full_name'] . ' Award Show';
			$this->view->metadata['title'] = [$data['show']['full_name'] . ' Award Show'];
			return ['content' => $this->view->render($data, 'admin/show_category')];
		}

		public function show_details() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}
			$show_id = securityCheck($this->db, $this->url[2]);

			$awardModel = $this->model('Award');
			$personModel = $this->model('People');
			$projectModel = $this->model('Project');
			$vendorModel = $this->model('Vendor');
			$studioModel = $this->model('Studio');

			$awardShowModel = $this->model('AwardShow');
			$data['show'] = $awardShowModel->getShowById($show_id);

			$awardShowYearModel = $this->model('AwardShowYear');
			$data['show_years'] = $awardShowYearModel->getAwardShowYearsByShowId($data['show']['id']);

			if (isset($_GET['sample']) && $_GET['sample'] != "") {
				$xAwardSampleId = securityCheck($this->db, $_GET['sample']);
				$getCheckboxes = $awardShowYearModel->getAwardCheckboxes($awardModel, $awardShowModel, $show_id, $xAwardSampleId);
				$data['awardCheckboxes'] = $getCheckboxes[0];
				$data['sample_name'] = $getCheckboxes[1];
				// $personModel, $projectModel, $vendorModel, $studioModel, $xAward, $xAwardShow, $show_year_id, 			$show_id, $show_year, $award_id, $winner_only)
				// $data['sample_nom_winners'] = getNomineesPage($award_show_id, $xAwardShowYear['year_existing'], $xAwardSample['id'], true);
				$xAward = $awardModel->getAwardById($xAwardSampleId);
				for($i = 0; $i < sizeof($data['show_years']); $i++) {
					$xShowYear = $data['show_years'][$i]['main'];
					if ($xShowYear['year_existing'] != "") {
						$data['sample_nom_winners'][$i] = $awardShowYearModel->getNomineesPage($personModel, $projectModel, $vendorModel, $studioModel, $xAward, $data['show'], $xShowYear['id'], $show_id, $xShowYear['year_existing'], $xAwardSampleId, true);
					} else {
						$data['sample_nom_winners'][$i] = "";
					}
				}
			} else {
				$getCheckboxes = $awardShowYearModel->getAwardCheckboxes($awardModel, $awardShowModel, $show_id, 0);
				$data['awardCheckboxes'] = $getCheckboxes[0];
				$data['sample_name'] = $getCheckboxes[1];
				$data['sample_nom_winners'] = "";
			}

			$networkModel = $this->model('Network');
			$data['networks'] = $networkModel->getAllNetworks();

			$data['awards_list_html'] = $awardModel->getAwardsByShowId($show_id);

			$data['page_title'] = $data['show']['full_name'] . ' Award Show';
			$this->view->metadata['title'] = [$data['show']['full_name'] . ' Award Show'];
			return ['content' => $this->view->render($data, 'admin/show_details')];

		}

		public function shows() {
			if ($this->globalUser == null) {
				redirect("index");
				return;
			}

			$awardShowModel = $this->model('AwardShow');
			$data['shows'] = $awardShowModel->getAllAwardShows();

			$data['page_title'] = 'Award Shows';
			$this->view->metadata['title'] = ['Award Shows'];
			return ['content' => $this->view->render($data, 'admin/shows')];

		}


}
