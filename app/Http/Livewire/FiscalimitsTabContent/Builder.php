<?php

namespace App\Http\Livewire\FiscalimitsTabContent;

use Livewire\Component;
use App\Models\User;
use App\Models\AllotmentClass;
use App\Models\FundChargeability;
use App\Models\FundChargeabilityClass;
use App\Models\FundChargeabilityClassAccount;
use App\Models\FiscalLimit;
use App\Models\ServiceRegion;



class Builder extends Component
{

    public $categories;
    public $category_codes;
    public $service_regions;
    public $regional_offices;
    public $central_offices;
    public $data_entry;
    public $test;



    public function render()
    {
        $this->categories =  AllotmentClass::with('fundChargeabilityClass.fundChargeability')->get();
        $this->service_regions =  ServiceRegion::get();
        $this->getCategoryCode();
        $this->getOffices();
        $this->setDataEntry();

        return view('livewire.fiscalimits-tab-content.builder');
    }
    public function getCategoryCode()
    {
        $this->category_codes = [];
        foreach ($this->categories as $allotment_class) {
            foreach ($allotment_class->fundChargeabilityClass as $class) {
                $allotment_class_code = $allotment_class->accronym;
                $fund_chargeability_code = $class->fundChargeability->accronym;
                $category_code = $allotment_class_code.'-'.$fund_chargeability_code;
                array_push($this->category_codes, $category_code);
            }
        }
        
    }
    public function getOffices()
    {
        $this->regional_offices = [];
        $this->central_offices = [];
        foreach ($this->service_regions as $office) {
            if ($office->co == 0) {
                array_push($this->regional_offices, $office);
            }
            else if ($office->co == 1) {
                array_push($this->central_offices, $office);
            }
        }
    }

    public function setDataEntry()
    {
        
     
        $this->data_entry=[];
       
        foreach ($this->regional_offices as $ro) {
            $index  = $ro->accronym;
            foreach ($this->category_codes as $cc) {
                $key = $ro->accronym.'-'.$cc;
                $this->data_entry['ro'][$index][$key] = null;
            }
            $this->data_entry['ro'][$index][$ro->accronym.'-TOTAL'] = null;   
        }

        foreach ($this->central_offices as $co) {
            $index  = $co->accronym;
            foreach ($this->category_codes as $cc) {
                $key = $co->accronym.'-'.$cc;
                $this->data_entry['co'][$index][$key] = null;
            }
            $this->data_entry['co'][$index][$co->accronym.'-TOTAL'] = null;   
        }

        // dd($this->data_entry);
    }

    public function test()
    {
       dd("test");
    }
}
