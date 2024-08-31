@extends('App')


@section('content-header', 'Detail Interaksi Customer')

@section('content')
    <x-content>
        <x-row>
            <x-card-collapsible>
                <x-row>
                    <form style="width: 100%" method="POST" action="{{ route('customer_interaction.update', $interaction->id) }}">
                        @csrf
                        @method('PATCH')

                        <x-row>
                            <x-in-text
                                :label="'Customer ID'"
                                :placeholder="'Customer ID'"
                                :col="2"
                                :id="'customer_id'"
                                :name="'customer_id'"
                                :value="$interaction->customer_id" readonly
                                :required="true"></x-in-text>
                            <x-in-text
                                :label="'Tanggal'"
                                :placeholder="'Tanggal'"
                                :col="4"
                                
                                :id="'date'"
                                :name="'date'"
                                :value="$interaction->date"
                                :required="true"></x-in-text>
                            <x-in-text
                                :label="'Catatan'"
                                :placeholder="'Catatan'"
                                :col="8"
                                :id="'notes'"
                                :name="'notes'"
                                :value="$interaction->notes"
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