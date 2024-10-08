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

                <x-col>
                    <x-table :thead="['Penanganan', 'Biaya', 'Deskripsi', 'Aksi']">
                        @foreach ($services as $service)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->cost}}</td>
                                <td>{{ $service->description }}</td>
                                <td>
                                    <a
                                    href="{{ route('service.show', $service->id) }}"
                                    class="btn btn-warning"
                                    title="Ubah"><i class="fas fa-pencil-alt"></i></a>

                                    <form style=" display:inline!important;" method="POST" action="{{ route('service.destroy', $service->id) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                            title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </x-table>
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
            <x-in-text col="4" :label="'Biaya'" :id="'cost'" :name="'cost'" :type="'number'" :required="true" />
            <x-in-text col="4" :label="'Deskripsi'" :id="'description'" :name="'description'" :required="true" />
        </x-row>

        <x-col class="text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </x-col>
    </form>
</x-modal>
@endsection
