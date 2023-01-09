<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Feeship;
use App\Models\Province;
use App\Models\Wards;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function delivery(Request $request)
    {
        $city = City::orderby('matp', 'ASC')->get();
        $Province = Province::orderby('maqh', 'ASC')->get();
        $ward = Wards::orderby('xaid', 'ASC')->get();

        return view('admin.delivery.add_delivery', compact('city', 'Province', 'ward'));
    }

    public function select_delivery(Request $request)
    {
        $data = $request->all();
        // while (strlen($data['ma_id']) < 5) {
        //     $data['ma_id'] = '0' . $data['ma_id'];
        // }
        if ($data['action']) {
            $output = '';
            if ($data['action'] == 'city') {
                if ($data['ma_id'] < 10) {
                    $id = '0' . $data['ma_id'];
                }
                $select_province = Province::where('matp', $id)->orderby('matp', 'ASC')->get();
                $output .= '<option>---Chọn quận huyện---</option>';
                foreach ($select_province as $key => $province) {
                    $output .= '<option value = "' . $province->maqh . '">' . $province->name_quanhuyen . '</option>';
                }
            } else {
                if ($data['ma_id'] < 100) {
                    $id = '00' . $data['ma_id'];
                } elseif ($data['ma_id'] < 10) {
                    $id = '0' . $data['ma_id'];
                }
                $select_wards = Wards::where('maqh', $id)->orderby('xaid', 'ASC')->get();
                $output .= '<option>---Chọn xã phường---</option>';
                foreach ($select_wards as $key => $province) {
                    $output .= '<option value = "' . $province->xaid . '">' . $province->name_xaphuong . '</option>';
                }
            }
        }
        echo $output;
    }

    public function insert_delivery(Request $request)
    {
        $data = $request->all();
        // dd($data);

        if ($data['city'] < 10) {
            $data['city'] = '0' . $data['city'];
        }
        if ($data['province'] < 100) {
            $data['province'] = '00' . $data['province'];
        } elseif ($data['province'] < 10) {
            $data['province'] = '0' . $data['province'];
        }
        while (strlen($data['wards']) < 5) {
            $data['wards'] = '0' . $data['wards'];
        }
        $fee_ship = new Feeship();
        $fee_ship->fee_matp = $data['city'];
        $fee_ship->fee_maqh = $data['province'];
        $fee_ship->fee_xaid = $data['wards'];
        $fee_ship->fee_feeship = $data['fee_ship'];
        // dd($fee_ship);
        $fee_ship->save();
    }

    public function select_feeship()
    {
        $feeship = Feeship::orderby('fee_id', 'ASC')->get();
        $output = '';
        $output .= '
        <div class="page-heading">
        <section class="section">
            <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" id="table-category">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên thành phố</th>
                                    <th>Tên quận huyện</th>
                                    <th>Tên xã phường</th>
                                    <th>Phí ship</th>
                                </tr>
                            </thread>
                            <tbody>';
        foreach ($feeship as $key => $fee) {
            $output .= '
                                    <tr>
                                        <td>' . $key + 1 . '</td>
                                        <td>' . $fee->city->name_city . '</td>
                                        <td>' . $fee->province->name_quanhuyen . '</td>
                                        <td>' . $fee->wards->name_xaphuong . '</td>
                                        <td  class = "fee_feeship_edit" contenteditable data-feeship_id="' . $fee->fee_id . '" >' . number_format($fee->fee_feeship, 0, ',', '.') . '</td>

                                    </tr>';
        }

        $output .= '
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>   ';
        echo $output;
    }

    public function update_delivery(Request $request)
    {
        $data = $request->all();
        $fee_ship = Feeship::find($data['feeship_id']);
        $fee_value = rtrim($data['fee_value'], '.');
        $fee_ship->fee_feeship = $fee_value;
        $fee_ship->save();
    }
}
