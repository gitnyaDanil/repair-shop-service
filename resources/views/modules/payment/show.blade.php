@extends('App')

@section('content-header', 'Detail Pembayaran')

@section('content')
    <x-content>
        <x-row>
            <x-card-collapsible>
                <x-row>
                    <form style="width: 100%" method="POST" action="{{ route('payment.update', $payment->id) }}">
                        @csrf
                        @method('PATCH')

                        <x-row>
                            <x-in-text
                                :label="'Invoice ID'"
                                :placeholder="'Invoice ID'"
                                :col="2"
                                :id="'invoice_id'"
                                :name="'invoice_id'"
                                :value="$payment->invoice_id"
                                readonly
                                :required="true"></x-in-text>

                            <x-in-text
                                :label="'Tanggal Dibayar'"
                                :placeholder="'Tanggal Dibayar'"
                                :col="4"
                                :id="'date_paid'"
                                :name="'date_paid'"
                                :value="$payment->date_paid"
                                :required="true"></x-in-text>

                            <x-in-text
                                :label="'Jumlah Pembayaran'"
                                :placeholder="'Jumlah Pembayaran'"
                                :col="4"
                                :id="'payment_amount'"
                                :name="'payment_amount'"
                                :value="$payment->payment_amount"
                                :required="true"></x-in-text>

                            <x-in-text
                                :label="'Payment Method'"
                                :placeholder="'Payment Method'"
                                :col="4"
                                :id="'payment_method'"
                                :name="'payment_method'"
                                :value="$payment->payment_method"
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
