@extends('App')


@section('content-header', 'Detail Invoice')

@section('content')
    <x-content>
        <x-row>
            <x-card-collapsible>
                <x-row>
                    <form style="width: 100%" method="POST" action="{{ route('invoice.update', $invoice->id) }}">
                        @csrf
                        @method('PATCH')

                        <x-row>
                            <x-in-text
                                :label="'Repair Order ID'"
                                :placeholder="'Repair Order ID'"
                                :col="2"
                                :id="'repair_order_id'"
                                :name="'repair_order_id'"
                                :value="$invoice->repair_order_id" readonly
                                :required="true"></x-in-text>
                            <x-in-text
                                :label="'Tanggal Dikeluarkan'"
                                :placeholder="'Tanggal Dikeluarkan'"
                                :col="4"
                                :id="'date_issued'"
                                :name="'date_issued'"
                                :value="$invoice->date_issued"
                                :required="true"></x-in-text>
                            <x-in-text
                                :label="'Payment Status'"
                                :placeholder="'Payment Status'"
                                :col="4"
                                :id="'payment_status'"
                                :name="'payment_status'"
                                :value="$invoice->payment_status"
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