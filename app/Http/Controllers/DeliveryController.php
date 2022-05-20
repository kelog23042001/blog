<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Feeship;
use App\Models\Province;
use App\Models\Wards;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function delivery(Request $request){
        $city = City::orderby('matp', 'ASC')->get();

        return view('admin.delivery.add_delivery', compact('city'));
    }

    public function select_delivery(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action'] == 'city'){
                $select_province = Province::where('matp', $data['ma_id'])->orderby('maqh', 'ASC')->get();
                $output.='<option>---Chọn quận huyện---</option>';
                foreach($select_province as $key => $province){
                    $output.='<option value = "'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }
            }else{
                $select_wards = Wards::where('maqh', $data['ma_id'])->orderby('xaid', 'ASC')->get();
                $output.='<option>---Chọn xã phường---</option>';
                foreach($select_wards as $key => $province){
                    $output.='<option value = "'.$province->xaid.'">'.$province->name_xaphuong.'</option>';
                }
            }
        }
        echo $output;
    }

    public function insert_delivery(Request $request){
        $data = $request->all();
        $fee_ship = new Feeship();
        $fee_ship->fee_matp = $data['city'];
        $fee_ship->fee_maqh = $data['province'];
        $fee_ship->fee_xaid = $data['wards'];
        $fee_ship->fee_feeship = $data['fee_ship'];
        $fee_ship->save();

    }

    public function select_feeship(){
        $feeship = Feeship::orderby('fee_id', 'ASC')->get();
        $output = '';
        $output.='<div class = "table-responsive">
            <table class = "table table-bordered">
                <thread>
                    <tr>
                        <td>Tên thành phố</td>
                        <td>Tên quận huyện</td>
                        <td>Tên xã phường</td>
                        <td>Phí ship</td>
                    </tr>
                </thread>
                <tbody>';
            foreach($feeship as $key =>$fee){
                $output.='
                        <tr>
                            <td>'.$fee->city->name_city.'</td>
                            <td>'.$fee->province->name_quanhuyen.'</td>
                            <td>'.$fee->wards->name_xaphuong.'</td>
                            <td  class = "fee_feeship_edit" contenteditable data-feeship_id="'.$fee->fee_id.'" >'.number_format($fee->fee_feeship,0,',','.').'</td>

                        </tr>';
            }

        $output.='
                </tbody>
            </table>
        </div>';
        echo $output;
    }

    public function update_delivery(Request $request){
        $data = $request->all();
        $fee_ship = Feeship::find($data['feeship_id']);
        $fee_value = rtrim($data['fee_value'],'.');
        $fee_ship->fee_feeship = $fee_value;
        $fee_ship->save();
    }
}
