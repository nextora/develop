<?php namespace App\Models;

class FieldModel extends BaseModel
{
    protected $builder;
    protected $builderFieldsOptions;
    protected $builderFieldsProduct;
    protected $builderFieldsCategory;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('custom_fields');
        $this->builderFieldsOptions = $this->db->table('custom_fields_options');
        $this->builderFieldsProduct = $this->db->table('custom_fields_product');
        $this->builderFieldsCategory = $this->db->table('custom_fields_category');
    }

    //input values
    public function inputValues()
    {
        return [
            'row_width' => inputPost('row_width'),
            'is_required' => !empty(inputPost('is_required')) ? 1 : 0,
            'where_to_display' => inputPost('where_to_display'),
            'status' => !empty(inputPost('status')) ? 1 : 0,
            'field_order' => inputPost('field_order')
        ];
    }

    //add field
    public function addField()
    {
        $data = $this->inputValues();
        if (empty($data['is_required'])) {
            $data['is_required'] = 0;
        }
        //generate filter key
        $fieldName = inputPost('name_lang_' . selectedLangId());
        $data['product_filter_key'] = $this->createProductFilterKey($fieldName);
        $data['field_type'] = inputPost('field_type');
        $nameArray = array();
        foreach ($this->activeLanguages as $language) {
            $item = [
                'lang_id' => $language->id,
                'name' => inputPost('name_lang_' . $language->id)
            ];
            array_push($nameArray, $item);
        }
        $data['name_array'] = serialize($nameArray);
        if ($this->builder->insert($data)) {
            return $this->db->insertID();
        }
        return false;
    }

    //update field
    public function editField($id)
    {
        $field = $this->getField($id);
        if (!empty($field)) {
            $data = $this->inputValues();
            if (empty($data['is_required'])) {
                $data['is_required'] = 0;
            }
            $key = inputPost('product_filter_key');
            $data['product_filter_key'] = $this->createProductFilterKey($key, $field->id);
            $data['field_type'] = inputPost('field_type');
            $nameArray = array();
            foreach ($this->activeLanguages as $language) {
                $item = [
                    'lang_id' => $language->id,
                    'name' => inputPost('name_lang_' . $language->id)
                ];
                array_push($nameArray, $item);
            }
            $data['name_array'] = serialize($nameArray);
            return $this->builder->where('id', $field->id)->update($data);
        }
        return false;
    }

    //create unique product filter key
    private function createProductFilterKey($name, $id = null)
    {
        $key = '';
        if (!empty($name)) {
            $key = strSlug($name);
            //check filter key exists
            $row = $this->getFieldByFilterKey($key, $id);
            if (!empty($row)) {
                $key = $key . '-' . rand(1, 999);
                $row = $this->getFieldByFilterKey($key, $id);
                if (!empty($row)) {
                    $key = $key . '-' . uniqid();
                }
            }
        }
        if (empty($key)) {
            $key = uniqid();
        }
        return $key;
    }

    //add field option
    public function addFieldOption($fieldId)
    {
        $mainOption = inputPost('option_lang_' . selectedLangId());
        $data = [
            'field_id' => $fieldId,
            'option_key' => strSlug($mainOption)
        ];
        $nameData = array();
        foreach ($this->activeLanguages as $language) {
            $option = inputPost('option_lang_' . $language->id);
            $item = [
                'lang_id' => $language->id,
                'name' => trim($option ?? '')
            ];
            array_push($nameData, $item);
        }
        $data['name_data'] = serialize($nameData);
        return $this->builderFieldsOptions->insert($data);
    }

    //edit field option
    public function editFieldOption()
    {
        $id = inputPost('id');
        $fieldOption = $this->getFieldOption($id);
        if (!empty($fieldOption)) {
            $mainOption = inputPost('option_lang_' . selectedLangId());
            $data = ['option_key' => strSlug($mainOption)];
            $nameData = array();
            foreach ($this->activeLanguages as $language) {
                $option = inputPost('option_lang_' . $language->id);
                $item = [
                    'lang_id' => $language->id,
                    'name' => trim($option ?? '')
                ];
                array_push($nameData, $item);
            }
            $data['name_data'] = serialize($nameData);
            $this->builderFieldsOptions->where('id', $fieldOption->id)->update($data);
        }
        return false;
    }

    //get field
    public function getField($id)
    {
        return $this->builder->where('id', clrNum($id))->get()->getRow();
    }

    //get field by filter key
    public function getFieldByFilterKey($filterKey, $exceptId = null)
    {
        if (!empty($exceptId)) {
            $this->builder->where('id != ', clrNum($exceptId));
        }
        return $this->builder->where('product_filter_key', $filterKey)->get()->getRow();
    }

    //get fields
    public function getFields()
    {
        return $this->builder->orderBy('field_order')->get()->getResult();
    }

    //get custom fields by category
    public function getCustomFieldsByCategory($categoryId)
    {
        $category = getCategory($categoryId);
        if (empty($category)) {
            return array();
        }
        $categories = getCategoryParentTree($category, true);
        $categoryIds = array();
        if (!empty($categories)) {
            $categoryIds = getIdsFromArray($categories);
        }
        if (!empty($categoryIds)) {
            return $this->builder->join('custom_fields_category', 'custom_fields_category.field_id = custom_fields.id')
                ->select('custom_fields.*, custom_fields_category.category_id AS category_id')
                ->where('custom_fields.status', 1)->whereIn('custom_fields_category.category_id', $categoryIds, false)->orderBy('custom_fields.field_order')->get()->getResult();
        }
        return array();
    }

    //get custom filters
    public function getCustomFilters($categoryId, $categories = null)
    {
        $key = 'custom_filters_by_cat_' . $categoryId;
        $rows = getCacheStatic($key);
        if (!empty($rows)) {
            return $rows;
        }
        $categoryIds = array();
        if (!empty($categories)) {
            $categoryIds = getIdsFromArray($categories);
        }
        if (!empty($categoryIds)) {
            $this->builder->join('custom_fields_category', 'custom_fields_category.field_id = custom_fields.id')->whereIn('custom_fields_category.category_id', $categoryIds, false);
        }
        $rows = $this->builder->select('custom_fields.*')->where('custom_fields.status', 1)->where('custom_fields.is_product_filter', 1)
            ->groupStart()->where('custom_fields.field_type', 'checkbox')->orWhere('custom_fields.field_type', 'radio_button')->orWhere('custom_fields.field_type', 'dropdown')->groupEnd()
            ->orderBy('custom_fields.field_order')->get()->getResult();
        setCacheStatic($key, $rows);
        return $rows;
    }

    //get field categories
    public function getFieldCategories($fieldId)
    {
        return $this->builderFieldsCategory->where('field_id', clrNum($fieldId))->get()->getResult();
    }

    //get field options
    public function getFieldOptions($customField, $langId)
    {
        if (!empty($customField)) {
            $this->builderFieldsOptions->where('custom_fields_options.field_id', clrNum($customField->id));
            if ($customField->sort_options == 'date') {
                $this->builderFieldsOptions->orderBy('custom_fields_options.id');
            }
            if ($customField->sort_options == 'date_desc') {
                $this->builderFieldsOptions->orderBy('custom_fields_options.id DESC');
            }
            if ($customField->sort_options == 'alphabetically') {
                $this->builderFieldsOptions->orderBy('option_key');
            }
            return $this->builderFieldsOptions->get()->getResult();
        }
        return array();
    }

    //get product filters options
    public function getProductFiltersOptions($customField, $langId, $customFilters, $queryStringArray = null)
    {
        $key = 'custom_filters_options_' . $customField->id;
        $rows = getCacheStatic($key);
        if (!empty($rows)) {
            return $rows;
        }
        if (!empty($customField)) {
            $this->builderFieldsOptions->where('custom_fields_options.field_id', clrNum($customField->id));
            if ($customField->sort_options == 'date') {
                $this->builderFieldsOptions->orderBy('custom_fields_options.id');
            }
            if ($customField->sort_options == 'date_desc') {
                $this->builderFieldsOptions->orderBy('custom_fields_options.id DESC');
            }
            if ($customField->sort_options == 'alphabetically') {
                $this->builderFieldsOptions->orderBy('option_key');
            }
            $rows = $this->builderFieldsOptions->get()->getResult();
            setCacheStatic($key, $rows);
            return $rows;
        }
        return array();
    }

    //update field options settings
    public function updateFieldOptionsSettings()
    {
        $fieldId = inputPost('field_id');
        $data = ['sort_options' => inputPost('sort_options')];
        return $this->builder->where('id', clrNum($fieldId))->update($data);
    }

    //get field all options
    public function getFieldAllOptions($fieldId)
    {
        return $this->builderFieldsOptions->where('custom_fields_options.field_id', clrNum($fieldId))->get()->getResult();
    }

    //get field option
    public function getFieldOption($optionId)
    {
        return $this->builderFieldsOptions->where('id', clrNum($optionId))->get()->getRow();
    }

    //add category to field
    public function addCategoryToField()
    {
        $fieldId = clrNum(inputPost('field_id'));
        $categoryId = getDropdownCategoryId();
        $row = $this->getCategoryField($fieldId, $categoryId);
        if (empty($row)) {
            $data = [
                'field_id' => $fieldId,
                'category_id' => $categoryId
            ];
            return $this->builderFieldsCategory->insert($data);
        }
        return false;
    }

    //get category field
    public function getCategoryField($fieldId, $categoryId)
    {
        return $this->builderFieldsCategory->where('field_id', clrNum($fieldId))->where('category_id', clrNum($categoryId))->get()->getRow();
    }

    //get product custom field values
    public function getProductCustomFieldValues($fieldId, $productId)
    {
        return $this->builderFieldsProduct->select('custom_fields_product.*, (SELECT name_data FROM custom_fields_options WHERE custom_fields_product.selected_option_id = custom_fields_options.id LIMIT 1) AS name_data')
            ->where('field_id', clrNum($fieldId))->where('product_id', clrNum($productId))->get()->getResult();
    }

    //get product custom field input value
    public function getProductCustomFieldInputValue($fieldId, $productId)
    {
        $row = $this->builderFieldsProduct->where('field_id', clrNum($fieldId))->where('product_id', clrNum($productId))->get()->getRow();
        if (!empty($row) && !empty($row->field_value)) {
            return $row->field_value;
        }
        return '';
    }

    //delete category from field
    public function deleteCategoryFromField($fieldId, $categoryId)
    {
        return $this->builderFieldsCategory->where('field_id', clrNum($fieldId))->where('category_id', clrNum($categoryId))->delete();
    }

    //delete custom field option
    public function deleteCustomFieldOption($id)
    {
        $option = $this->getFieldOption($id);
        if (!empty($option)) {
            $this->builderFieldsOptions->where('id', $option->id)->delete();
        }
    }

    //add remove custom field filters
    public function addRemoveCustomFieldFilters($fieldId)
    {
        $field = $this->getField($fieldId);
        if (!empty($field)) {
            if ($field->is_product_filter == 1) {
                $data = ['is_product_filter' => 0];
            } else {
                $data = ['is_product_filter' => 1];
            }
            return $this->builder->where('id', $field->id)->update($data);
        }
    }

    //get product filter values array
    public function getProductFilterValuesArray($productId, $brand)
    {
        $arrayTop = array();
        $arrayBottom = array();
        if (!empty($brand)) {
            $data = [
                'name' => trans('brand'),
                'value' => $brand
            ];
            if ($this->productSettings->brand_where_to_display == 1) {
                array_push($arrayTop, $data);
            } else {
                array_push($arrayBottom, $data);
            }
        }

        $result = $this->builderFieldsProduct->select('custom_fields_product.*,
        custom_fields.name_array AS field_name_array, field_type, where_to_display,
        (SELECT name_data FROM custom_fields_options WHERE custom_fields_product.selected_option_id = custom_fields_options.id LIMIT 1) AS option_name_data')
            ->join('custom_fields', 'custom_fields_product.field_id = custom_fields.id')
            ->where('custom_fields.status', 1)->where('product_id', clrNum($productId))->orderBy('custom_fields.field_order')->get()->getResult();
        $array = array();
        if (!empty($result)) {
            foreach ($result as $item) {
                $array[$item->field_id][] = $item;
            }
        }
        if (!empty($array)) {
            foreach ($array as $options) {
                if (!empty($options)) {
                    $whereToDisplay = 2;
                    $fieldName = '';
                    $fieldValue = '';
                    foreach ($options as $option) {
                        $whereToDisplay = $option->where_to_display;
                        $fieldName = @parseSerializedNameArray($option->field_name_array, selectedLangId());
                        if ($option->field_type == 'text' || $option->field_type == 'textarea' || $option->field_type == 'number' || $option->field_type == 'date') {
                            $fieldValue = $option->field_value;
                        } else {
                            $selectedOp = getCustomFieldOptionName($option->option_name_data, selectedLangId());
                            $fieldValue .= $selectedOp . ', ';
                        }
                    }
                    if (!empty($fieldValue)) {
                        $fieldValue = trim($fieldValue);
                        $fieldValue = trim($fieldValue, ',');
                    }
                    $data = [
                        'name' => $fieldName,
                        'value' => $fieldValue
                    ];
                    if ($whereToDisplay == 1) {
                        array_push($arrayTop, $data);
                    } else {
                        array_push($arrayBottom, $data);
                    }
                }
            }
        }
        return ['top' => $arrayTop, 'bottom' => $arrayBottom];
    }

    //delete field product values by product id
    public function deleteFieldProductValuesByProductId($productId)
    {
        if (!empty($productId)) {
            $this->builderFieldsProduct->where('product_id', clrNum($productId))->delete();
        }
    }

    //delete field
    public function deleteField($id)
    {
        $field = $this->getField($id);
        if (!empty($field)) {
            $this->builderFieldsCategory->where('field_id', $field->id)->delete();
            $options = $this->builderFieldsOptions->where('field_id', $field->id)->get()->getResult();
            if (!empty($options)) {
                foreach ($options as $option) {
                    $this->builderFieldsOptions->where('id', $option->id)->delete();
                }
            }
            $this->builderFieldsProduct->where('field_id', $field->id)->delete();
            return $this->builder->where('id', $field->id)->delete();
        }
        return false;
    }

    //import csv item
    public function importCsvItem($txtFileName, $index)
    {
        $filePath = FCPATH . 'uploads/temp/' . $txtFileName;
        $file = fopen($filePath, 'r');
        $content = fread($file, filesize($filePath));
        $array = @unserializeData($content);
        if (!empty($array)) {
            $i = 1;
            foreach ($array as $item) {
                if ($i == $index) {
                    $data = array();
                    $name = getCsvValue($item, 'name');
                    $data['product_filter_key'] = $this->createProductFilterKey($name);
                    $fieldType = getCsvValue($item, 'field_type');
                    $data['field_type'] = 'radio_button';
                    if ($fieldType == 'checkbox' || $fieldType == 'dropdown') {
                        $data['field_type'] = $fieldType;
                    }
                    $data['row_width'] = getCsvValue($item, 'row_width') == 'half' ? 'half' : 'full';
                    $data['is_required'] = getCsvValue($item, 'is_required', 'int') == 1 ? 1 : 0;
                    $data['status'] = getCsvValue($item, 'status', 'int') == 1 ? 1 : 0;
                    $data['is_product_filter'] = getCsvValue($item, 'is_product_filter', 'int') == 1 ? 1 : 0;
                    $data['field_order'] = getCsvValue($item, 'status', 'int');
                    $data['sort_options'] = 'alphabetically';
                    $data['where_to_display'] = 2;
                    //create name array
                    $nameArray = array();
                    foreach ($this->activeLanguages as $language) {
                        $n = [
                            'lang_id' => $language->id,
                            'name' => $name
                        ];
                        array_push($nameArray, $n);
                    }
                    $data['name_array'] = serialize($nameArray);
                    if ($this->builder->insert($data)) {
                        $lastId = $this->db->insertID();
                        //add categories
                        $categoryIds = getCsvValue($item, 'category_id');
                        $categoryArray = array();
                        if (!empty($categoryIds)) {
                            $categoryArray = explode(',', $categoryIds);
                            if (!empty($categoryArray) && countItems($categoryArray) > 0) {
                                foreach ($categoryArray as $categoryId) {
                                    $categoryId = clrNum($categoryId);
                                    if (!empty($categoryId) && empty($this->getCategoryField($lastId, $categoryId))) {
                                        $c = [
                                            'field_id' => $lastId,
                                            'category_id' => $categoryId
                                        ];
                                        $this->builderFieldsCategory->insert($c);
                                    }
                                }
                            }
                        }

                        //add options
                        $options = getCsvValue($item, 'options');
                        $optionsArray = array();
                        if (!empty($options)) {
                            $optionsArray = explode(',', $options);
                            if (!empty($optionsArray) && countItems($optionsArray) > 0) {
                                foreach ($optionsArray as $option) {
                                    $option = trim($option ?? '');
                                    if (!empty($option)) {
                                        $data = [
                                            'field_id' => $lastId,
                                            'option_key' => strSlug($option)
                                        ];
                                        $nameData = array();
                                        foreach ($this->activeLanguages as $language) {
                                            $o = [
                                                'lang_id' => $language->id,
                                                'name' => $option
                                            ];
                                            array_push($nameData, $o);
                                        }
                                        $data['name_data'] = serialize($nameData);
                                        $this->builderFieldsOptions->insert($data);
                                    }
                                }
                            }
                        }
                        return $name;
                    }
                }
                $i++;
            }
        }
    }
}
