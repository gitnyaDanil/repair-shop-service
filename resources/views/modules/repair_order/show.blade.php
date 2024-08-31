@extends('App')


@section('content-header', 'Order Perbaikan')

@section('content')
    <x-content>
        <x-row>
            <x-card-collapsible>
                <x-row>
                    <form style="width: 100%" method="POST" action="{{ route('repair_order.update', $repair_order->id) }}">
                        @csrf
                        @method('PATCH')

                        <x-row>
                            <x-in-text
                                :label="'Customer ID'"
                                :placeholder="'Customer ID'"
                                :col="2"
                                :id="'customer_id'"
                                :name="'customer_id'"
                                :value="$repair_order->customer_id" readonly
                                :required="true"></x-in-text>
                            <x-in-text
                                :label="'Tanggal Penerimaan'"
                                :placeholder="'Tanggal Penerimaan'"
                                :col="4"
                                
                                :id="'date_received'"
                                :name="'date_received'"
                                :value="$repair_order->date_received"
                                :required="true"></x-in-text>
                            <x-in-text
                                :label="'Tanggal Perkiraan Selesai'"
                                :placeholder="'Tanggal Perkiraan Selesai'"
                                :col="4"
                                :id="'estimated_completion_waktu'"
                                :name="'estimated_completion_waktu'"
                                :value="$repair_order->estimated_completion_waktu"
                                :required="true"></x-in-text>
                            <x-in-text
                                :label="'Status'"
                                :placeholder="'Status'"
                                :col="4"
                                :id="'status'"
                                :name="'status'"
                                :value="$repair_order->status"
                                :required="true"></x-in-text>
                            <x-in-text
                                :label="'Total Biaya'"
                                :placeholder="'Total Biaya'"
                                :col="4"
                                :id="'total_cost'"
                                :name="'total_cost'"
                                :value="$repair_order->total_cost"
                                :required="true"></x-in-text>
                            
                        </x-row>

                        <x-col class="text-right">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                        </x-col>
                    </form>
                </x-row>
            </x-card-collapsible>
        </x-row>
    </x-content>
@endsection