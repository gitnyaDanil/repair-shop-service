@extends('App')


@section('content-header', 'Detail Customer')

@section('content')
    <x-content>
        <x-row>
            <x-card-collapsible>
                <x-row>
                    <form style="width: 100%" method="POST" action="{{ route('customer.update', $customer->id) }}">
                        @csrf
                        @method('PATCH')

                        <x-row>
                            <x-in-text
                                :label="'First Name'"
                                :placeholder="'Nama Depan'"
                                :col="4"
                                :id="'first_name'"
                                :name="'first_name'"
                                :value="$customer->first_name"
                                :required="true"></x-in-text>
                            <x-in-text
                                :label="'Last Name'"
                                :placeholder="'Nama Keluarga'"
                                :col="4"
                                
                                :id="'last_name'"
                                :name="'last_name'"
                                :value="$customer->last_name"
                                :required="false"></x-in-text>
                            <x-in-text
                                :label="'Contact Info'"
                                :placeholder="'Kontak'"
                                :col="4"
                                :id="'contact_info'"
                                :name="'contact_info'"
                                :value="$customer->contact_info"
                                :required="false"></x-in-text>
                            <x-in-text
                                :label="'Address'"
                                :placeholder="'Alamat'"
                                :col="4"
                                :id="'address'"
                                :name="'address'"
                                :value="$customer->address"
                                :required="false"></x-in-text>
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