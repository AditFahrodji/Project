<div class="container mx-auto px-4 py-10 sm:px-6 lg:px-8">
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach ($kategoris as $index => $kategori)
      <a href="/produk?selected_kategoris[0]={{ $kategori->id }}" class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden hover:shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 dark:bg-slate-900 dark:border-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
        <div class="relative overflow-hidden">
          <img class="h-64 w-full object-cover transition duration-300 ease-in-out transform scale-100 group-hover:scale-105" src="{{ url('storage', $kategori->gambar) }}" alt="Image Description">
          <div class="absolute inset-0 bg-black opacity-50 transition duration-300 ease-in-out opacity-0 group-hover:opacity-100"></div>
          <div class="absolute inset-0 flex justify-center items-center opacity-0 group-hover:opacity-100">
            <h3 class="text-white text-3xl font-semibold text-center z-10">{{ $kategori->nama }}</h3>
          </div>
        </div>
        <div class="p-6 md:p-8">
          <svg class="absolute top-0 right-0 w-12 h-12 text-gray-600 transform translate-x-1/2 -translate-y-1/2 transition duration-300 ease-in-out opacity-0 group-hover:opacity-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </div>
      </a>
    @endforeach
  </div>
</div>
