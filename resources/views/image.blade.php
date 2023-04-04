@extends('main')

@section('visitorContent')

    <div class="relative flex items-center min-h-screen justify-center overflow-hidden">
            <form action="{{ route('image.store') }}" method="POST" class="shadow p-12" enctype="multipart/form-data">
                @csrf
                <label class="block mb-4">
                    <span class="sr-only">Choose File</span>
                    <input type="file" name="image"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    @error('image')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </label>
                <div>
                    <label class="mr-4" for="name">name</label>
                    <input type="text" name="name">
                    <label class="mr-4" for="area">area</label>
                    <input type="text" name="area">
                    <label class="mr-4" for="country">country</label>
                    <input type="text" name="country">
                </div>
                <button type="submit" class="mt-4 px-4 py-2 text-sm text-black bg-indigo-600 rounded">Submit</button>
            </form>
        </div>

@endsection('visitorContent')