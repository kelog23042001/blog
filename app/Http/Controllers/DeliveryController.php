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
        // dd($data);
        if ($data['action']) {
            $output = '';
            if ($data['action'] == 'city') {
                $select_province = Province::where('matp', $data['ma_id'])->orderby('maqh', 'ASC')->get();
                $a = Province::get();
                $output .= '<option>---Chọn quận huyện---</option>';
                dd($a);
                foreach ($select_province as $key => $province) {
                    $output .= '<option value = "' . $province->maqh . '">' . $province->name_quanhuyen . '</option>';
                }
            } else {
                $select_wards = Wards::where('maqh', $data['ma_id'])->orderby('xaid', 'ASC')->get();
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
