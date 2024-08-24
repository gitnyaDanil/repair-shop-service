@extends('App')

@section('content-header', 'Daftar Service')

@section('content')
<x-content>
    <x-row>
        <x-card-collapsible>
            <x-row>
                <x-col class="mb-3">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-modal">Tambah</button>
                </x-col>
            </x-row>
        </x-card-collapsible>
    </x-row>
</x-content>

<x-modal :title="'Tambah Data'" :id="'add-modal'" :size="'xl'">
    <form style="width: 100%" action="{{ route('service.store') }}" method="POST">
        @csrf
        @method('POST')

        <x-row>
            <x-in-text col="4" :label="'Nama'" :id="'name'" :name="'name'" :required="true" />
            <x-in-text col="4" :label="'Harga'" :id="'price'" :name="'price'" :required="true" />
            <x-in-text col="4" :label="'Deskripsi'" :id="'description'" :name="'description'" :required="true" />
        </x-row>

        <x-col class="text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </x-col>
    </form>
</x-modal>
@endsection
