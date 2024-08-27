@extends('App')


@section('content-header', 'Detail Service')

@section('content')
    <x-content>
        <x-row>
            <x-card-collapsible>
                <x-row>
                    <form style="width: 100%" method="POST" action="{{ route('service.update', $service->id) }}">
                        @csrf
                        @method('PATCH')

                        <x-row>
                            <x-in-text
                                :label="'Nama'"
                                :placeholder="'Penanganan Service'"
                                :col="4"
                                :id="'name'"
                                :name="'name'"
                                :value="$service->name"
                                :required="true"></x-in-text>
                            <x-in-text
                                :label="'Biaya'"
                                :placeholder="'Biaya Service'"
                                :col="4"
                                :type="'number'"
                                :id="'cost'"
                                :name="'cost'"
                                :value="$service->cost"
                                :required="true"></x-in-text>
                            <x-in-text
                                :label="'Deskripsi'"
                                :placeholder="'Deskripsi Service'"
                                :col="4"
                                :id="'description'"
                                :name="'description'"
                                :value="$service->description"
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
