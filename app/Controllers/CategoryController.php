<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\FieldModel;
use App\Models\FileModel;
use App\Models\UploadModel;

class CategoryController extends BaseAdminController
{
    protected $fieldModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $panelSettings = getPanelSettings();
        $this->fieldModel = new FieldModel();
    }

    /**
     * Categories
     */
    public function categories()
    {
        checkPermission('categories');
        $this->categoryModel->checkCategoryParentTrees();
        $data['title'] = trans("categories");
        $data['lang'] = inputGet('lang');
        if (empty($data['lang'])) {
            $data["lang"] = selectedLangId();
        }
        if (!checkLanguageExist($data['lang'])) {
            $data['lang'] = selectedLangId();
            redirectToUrl(adminUrl('categories?lang=' . selectedLangId()));
        }
        $data['parentCategories'] = $this->categoryModel->getParentCategories(true);
        $q = cleanStr(inputGet('q'));
        if (!empty($q)) {
            $numRows = $this->categoryModel->getCategoriesSearchCount();
            $data['pager'] = paginate($this->perPage, $numRows);
            $data['searchCategories'] = $this->categoryModel->getCategoriesSearchPaginated($this->perPage, $data['pager']->offset);
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/category/categories', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Category
     */
    public function addCategory()
    {
        checkPermission('categories');
        $data['title'] = trans("add_category");
        $data['parentCategories'] = $this->categoryModel->getParentCategories(true);

        echo view('admin/includes/_header', $data);
        echo view('admin/category/add_category', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Category Post
     */
    public function addCategoryPost()
    {
        checkPermission('categories');
        if ($this->categoryModel->addCategory()) {
            setSuccessMessage(trans("msg_added"));
            resetCacheDataOnChange();
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Edit Category
     */
    public function editCategory($id)
    {
        checkPermission('categories');
        $data['title'] = trans("update_category");
        $data['category'] = $this->categoryModel->getCategory($id);
        if (empty($data['category'])) {
            return redirect()->to(adminUrl('categories'));
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/category/edit_category', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Update Category Post
     */
    public function editCategoryPost()
    {
        checkPermission('categories');
        $id = inputPost('id');
        if ($this->categoryModel->editCategory($id)) {
            setSuccessMessage(trans("msg_updated"));
            resetCacheDataOnChange();
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Bulk Category Upload
     */
    public function bulkCategoryUpload()
    {
        checkPermission('categories');
        $data['title'] = trans("bulk_category_upload");

        echo view('admin/includes/_header', $data);
        echo view('admin/category/bulk_category_upload', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Download CSV Files Post
     */
    public function downloadCsvFilesPost()
    {
        checkPermission('categories');
        $submit = inputPost('submit');
        if ($submit == 'csv_template') {
            return $this->response->download(FCPATH . 'assets/file/csv_category_template.csv', null);
        } elseif ($submit == 'csv_example') {
            return $this->response->download(FCPATH . 'assets/file/csv_category_example.csv', null);
        }
    }

    /**
     * Generate CSV Object Post
     */
    public function generateCsvObjectPost()
    {
        checkPermission('categories');
        $fileModel = new FileModel();
        $csvObject = $fileModel->generateCsvObjectFile();
        if (!empty($csvObject)) {
            $data = [
                'result' => 1,
                'number_of_items' => $csvObject->number_of_items,
                'txt_file_name' => $csvObject->txt_file_name,
            ];
            echo json_encode($data);
            exit();
        }
        $data = ['result' => 0];
        echo json_encode($data);
        exit();
    }

    /**
     * Import CSV Item Post
     */
    public function importCsvItemPost()
    {
        $txtFileName = inputPost('txt_file_name');
        $index = inputPost('index');
        $name = $this->categoryModel->importCsvItem($txtFileName, $index);
        if (!empty($name)) {
            $data = [
                'result' => 1,
                'name' => $name,
                'index' => $index
            ];
            echo json_encode($data);
        } else {
            $data = [
                'result' => 0,
                'index' => $index
            ];
            echo json_encode($data);
        }
        resetCacheDataOnChange();
    }

    /**
     * Category Settings Post
     */
    public function categorySettingsPost()
    {
        checkPermission('categories');
        if ($this->categoryModel->updateSettings()) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        return redirect()->back();
    }

    /**
     * Delete Category Post
     */
    public function deleteCategoryPost()
    {
        checkPermission('categories');
        $id = inputPost('id');
        if (!empty($this->categoryModel->getSubCategoriesByParentId($id))) {
            setErrorMessage(trans("msg_delete_subcategories"));
        } else {
            if ($this->categoryModel->deleteCategory($id)) {
                setSuccessMessage(trans("msg_deleted"));
                resetCacheDataOnChange();
            } else {
                setErrorMessage(trans("msg_error"));
            }
        }
    }

    /**
     * Edit featured categories order
     */
    public function editFeaturedCategoriesOrderPost()
    {
        checkPermission('categories');
        $this->categoryModel->editFeaturedCategoriesOrder();
        resetCacheDataOnChange();
    }

    /**
     * Edit index categories order
     */
    public function editIndexCategoriesOrderPost()
    {
        checkPermission('categories');
        $this->categoryModel->editIndexCategoriesOrder();
        resetCacheDataOnChange();
    }

    /**
     * Load categories
     */
    public function loadCategories()
    {
        checkPermission('categories');
        $data = [
            'result' => 0
        ];
        $subCategories = $this->categoryModel->getSubCategoriesByParentId(inputPost('id'));
        if (!empty($subCategories)) {
            $data = [
                'result' => 1,
                'htmlContent' => view('admin/category/_categories_print', ['categories' => $subCategories, 'padding' => true])
            ];
        }
        echo json_encode($data);
    }

    /**
     * Delete category image
     */
    public function deleteCategoryImagePost()
    {
        checkPermission('categories');
        $categoryId = inputPost('category_id');
        $this->categoryModel->deleteCategoryImage($categoryId);
        resetCacheDataOnChange();
    }

    /*
     * --------------------------------------------------------------------
     * Custom Fields
     * --------------------------------------------------------------------
     */

    /**
     * Custom Fields
     */
    public function customFields()
    {
        checkPermission('custom_fields');
        $data['title'] = trans("custom_fields");
        $data['fields'] = $this->fieldModel->getFields();

        echo view('admin/includes/_header', $data);
        echo view('admin/category/custom_fields', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Custom Field
     */
    public function addCustomField()
    {
        checkPermission('custom_fields');
        $data['title'] = trans("add_custom_field");
        $data['categories'] = $this->categoryModel->getParentCategories(true);

        echo view('admin/includes/_header', $data);
        echo view('admin/category/add_custom_field', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Custom Field Post
     */
    public function addCustomFieldPost()
    {
        checkPermission('custom_fields');
        $insertId = $this->fieldModel->addField();
        if ($insertId) {
            return redirect()->to(adminUrl('custom-field-options/' . $insertId));
        }
        setErrorMessage(trans("msg_error"));
        return redirect()->back()->withInput();
    }

    /**
     * Edit Custom Field
     */
    public function editCustomField($id)
    {
        checkPermission('custom_fields');
        $data['title'] = trans("update_custom_field");
        $data['field'] = $this->fieldModel->getField($id);
        if (empty($data['field'])) {
            return redirect()->to(adminUrl('custom-fields'));
        }
        $data['categories'] = $this->categoryModel->getParentCategories(true);
        $data['fieldCategories'] = $this->fieldModel->getFieldCategories($data['field']->id);

        echo view('admin/includes/_header', $data);
        echo view('admin/category/edit_custom_field', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Update Custom Field Post
     */
    public function editCustomFieldPost()
    {
        checkPermission('custom_fields');
        $id = inputPost('id');
        if ($this->fieldModel->editField($id)) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Delete Custom Field Post
     */
    public function deleteCustomFieldPost()
    {
        checkPermission('custom_fields');
        $id = inputPost('id');
        if ($this->fieldModel->deleteField($id)) {
            setSuccessMessage(trans("msg_deleted"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
    }

    /**
     * Add Remove Custom Fields Filters
     */
    public function addRemoveCustomFieldFiltersPost()
    {
        checkPermission('custom_fields');
        $id = inputPost('id');
        if ($this->fieldModel->addRemoveCustomFieldFilters($id)) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Custom Field Options
     */
    public function customFieldOptions($id)
    {
        checkPermission('custom_fields');
        $data['title'] = trans("add_custom_field");
        $data['field'] = $this->fieldModel->getField($id);
        if (empty($data['field'])) {
            return redirect()->to(adminUrl('custom-fields'));
        }
        $data['parentCategories'] = $this->categoryModel->getParentCategories(true);
        $data['options'] = $this->fieldModel->getFieldAllOptions($id);
        $data['fieldCategories'] = $this->fieldModel->getFieldCategories($id);

        echo view('admin/includes/_header', $data);
        echo view('admin/category/custom_field_options', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add custom field option
     */
    public function addCustomFieldOptionPost()
    {
        checkPermission('custom_fields');
        $fieldId = inputPost('field_id');
        $this->fieldModel->addFieldOption($fieldId);
        redirectToBackUrl();
    }

    /**
     * Update Custom Field Option Post
     */
    public function editCustomFieldOptionPost()
    {
        checkPermission('custom_fields');
        $this->fieldModel->editFieldOption();
        redirectToBackUrl();
    }

    /**
     * Delete custom field option
     */
    public function deleteCustomFieldOption()
    {
        checkPermission('custom_fields');
        $id = inputPost('id');
        $this->fieldModel->deleteCustomFieldOption($id);
    }

    /**
     * Add category to custom field
     */
    public function addCategoryToCustomField()
    {
        checkPermission('custom_fields');
        $this->fieldModel->addCategoryToField();
        redirectToBackUrl();
    }

    /**
     * Custom Field Settings Post
     */
    public function customFieldSettingsPost()
    {
        checkPermission('custom_fields');
        if ($this->fieldModel->updateFieldOptionsSettings()) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Bulk Custom Field Upload
     */
    public function bulkCustomFieldUpload()
    {
        checkPermission('custom_fields');
        $data['title'] = trans("bulk_custom_field_upload");

        echo view('admin/includes/_header', $data);
        echo view('admin/category/bulk_custom_field_upload', $data);
        echo view('admin/includes/_footer');
    }


    /**
     * Generate CSV Object Custom Field Post
     */
    public function generateCsvObjectCustomFieldPost()
    {
        checkPermission('custom_fields');
        $fileModel = new FileModel();
        $csvObject = $fileModel->generateCsvObjectFile();
        if (!empty($csvObject)) {
            $data = [
                'result' => 1,
                'number_of_items' => $csvObject->number_of_items,
                'txt_file_name' => $csvObject->txt_file_name,
            ];
            echo json_encode($data);
            exit();
        }
        $data = ['result' => 0];
        echo json_encode($data);
        exit();
    }

    /**
     * Import CSV Custom Field Post
     */
    public function importCsvCustomFieldPost()
    {
        $txtFileName = inputPost('txt_file_name');
        $index = inputPost('index');
        $name = $this->fieldModel->importCsvItem($txtFileName, $index);
        if (!empty($name)) {
            $data = [
                'result' => 1,
                'name' => $name,
                'index' => $index
            ];
            echo json_encode($data);
        } else {
            $data = [
                'result' => 0,
                'index' => $index
            ];
            echo json_encode($data);
        }
    }

    /**
     * Download CSV Files Custom Field Post
     */
    public function downloadCsvFilesCustomFieldPost()
    {
        checkPermission('custom_fields');
        $submit = inputPost('submit');
        if ($submit == 'csv_template') {
            return $this->response->download(FCPATH . 'assets/file/csv_custom_field_template.csv', null);
        } elseif ($submit == 'csv_example') {
            return $this->response->download(FCPATH . 'assets/file/csv_custom_field_example.csv', null);
        }
    }

    /**
     * Delete category from a custom field
     */
    public function deleteCategoryFromField()
    {
        checkPermission('custom_fields');
        $fieldId = inputPost('field_id');
        $categoryId = inputPost('category_id');
        $this->fieldModel->deleteCategoryFromField($fieldId, $categoryId);
    }


    /**
     * --------------------------------------------------------------------------
     * Brands
     * --------------------------------------------------------------------------
     */

    /**
     * Brands
     */
    public function brands()
    {
        checkPermission('brands');
        $data['title'] = trans("brands");
        
        $numRows = $this->commonModel->getBrandsCount();
        $data['pager'] = paginate($this->perPage, $numRows);
        $data['brands'] = $this->commonModel->getBrandsPaginated($this->perPage, $data['pager']->offset);

        echo view('admin/includes/_header', $data);
        echo view('admin/brand/brands', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Brand
     */
    public function addBrand()
    {
        checkPermission('brands');
        $data['title'] = trans("add_brand");
        
        $data['parentCategories'] = $this->categoryModel->getParentCategories(true);

        echo view('admin/includes/_header', $data);
        echo view('admin/brand/add', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Brand
     */
    public function editBrand($id)
    {
        checkPermission('brands');
        $data['title'] = trans("edit_brand");
        

        $data['brand'] = $this->commonModel->getBrand($id);
        if (empty($data['brand'])) {
            redirectToUrl(adminUrl('brands'));
        }
        $data['parentCategories'] = $this->categoryModel->getParentCategories(true);

        echo view('admin/includes/_header', $data);
        echo view('admin/brand/edit', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Brand Post
     */
    public function addBrandPost()
    {
        checkPermission('brands');
        if ($this->commonModel->addBrand()) {
            setSuccessMessage(trans("msg_added"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        return redirect()->to(adminUrl('add-brand'));
    }

    /**
     * Edit Brand Post
     */
    public function editBrandPost()
    {
        checkPermission('brands');
        if ($this->commonModel->editBrand()) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        redirectToBackUrl();
    }

    /**
     * Delete Brand Post
     */
    public function deleteBrandPost()
    {
        checkPermission('brands');
        $id = inputPost('id');
        if ($this->commonModel->deleteBrand($id)) {
            setSuccessMessage(trans("msg_deleted"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        exit();
    }

    /**
     * Brand Settings Post
     */
    public function brandSettingsPost()
    {
        checkPermission('brands');
        if ($this->commonModel->updateBrandSettings()) {
            setSuccessMessage(trans("msg_updated"));
        } else {
            setErrorMessage(trans("msg_error"));
        }
        return redirect()->to(adminUrl('brands'));
    }
}