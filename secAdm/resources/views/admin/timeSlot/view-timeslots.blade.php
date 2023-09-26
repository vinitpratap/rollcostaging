@extends('admin.layouts.app')

@section('content')

@php 

$timeSlotArr = array('1'=>'06:00 AM - 02:00 PM','2'=>'04:00 PM - 10:00 PM');

$dayArr = array('1'=>'Mon','2'=>'Tue','3'=>'Wed','4'=>'Thu','5'=>'Fri','6'=>'Sat','7'=>'Sun');

@endphp
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel row m-0">
            <div class="x_title">
                <h2>Manage TimeSlots</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content pt-4 mb-3 col-12 clearfix">
                <div class="table-responsive-md collRquest pb-4">
                    <table id="datatable" class="table table-striped ">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">Time Slots</th>
                                <th class="column-title">Days</th>
                                <th class="column-title">Action</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach($data as $key=>$value)
                            <tr class="pointer">
                                <td>
                                    <?php
                                    if (isset($timeSlotArr[$value->time_slot])) {
                                        echo $timeSlotArr[$value->time_slot];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $days = explode(',', $value->days);
                                    $dayStr = '';
                                    for ($i = 0; $i< count($days); $i++) {
                                        if (isset($dayArr[$days[$i]])) {
                                            $dayStr .= $dayArr[$days[$i]].",";
                                        }
                                    }
                                    echo rtrim($dayStr,',');
                                    ?>
                                </td>
                                <td class="last">
                                    <a href="javascript:void(0);" title="Edit" class="mr-4 ml-2 d-inline-block"><img data-id="{{base64_encode($value->id)}}" class="editTimeSlot" src="{{ URL::asset('images/edit.svg') }}" alt=""></a> 
                                    <a href="{{route('timeslot.delete',base64_encode($value->id))}}"  title="Delete" class="d-inline-block delete confirmation"><img src="{{ URL::asset('images/delete.svg') }}" alt=""></a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>


        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="x_panel newRequestForm">
            <div class="x_title">
                <h2 id="titleText">Add Time Slots </h2>
                <div class="clearfix"></div>
            </div>
            <form method="post" id="timeslotRegister" action="{{route('timeslot.register')}} "> 

                {{ csrf_field() }}
                <input type="hidden" name="id" id="slot_id">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.								
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach								
                </div>
                @endif
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                <input type="hidden" id="seltimeslottext" name="time_slot_name">
                <div class="row mt-4">
                    <div class="col-md-4 mb-3 padRig">
                        <label for="fromtimeSlots">Time Slots</label>
                        @if ($errors->has('status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('time_slot') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select"   id="time_slot" name="time_slot">
                            <option value="">Select Time Slot</option>
                            <option value="1">06:00 AM - 02:00 PM</option>
                            <option value="2">04:00 PM - 10:00 PM</option>
                        </select>
                    </div>

                </div>
                <div class="row mt-4">
                    <div class="col-md-12 mb-3">
                        <label for="selectDays">Select Days (Multiple)</label>
                        @if ($errors->has('status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('days') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select2_multiple" multiple="multiple"  id="selectDays" name="days[]" required="required">
                            <option value="1" >Mon</option>
                            <option value="2" >Tue</option>
                            <option value="3">Wed </option>
                            <option value="4">Thu </option>
                            <option value="5">Fri </option>
                            <option value="6">Sat </option>
                            <option value="7">Sun </option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4 mb-3 padRig">
                        <label for="status">Status </label>
                        @if ($errors->has('status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('status') }}</strong>
                        </span>
                        @endif
                        <select  class="form-control select"   id="cstatus" name="status">
                            <option value="1">Enable</option>
                            <option value="0">Disable</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12  pb-3 clearfix"><button type="submit" class="btn btn-secondary pl-4 pr-4 pt-2 pb-2  m-0 text-uppercase" id="submitTimeSlot">Add </button></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection