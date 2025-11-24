<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหาข้อมูลห้องปฏิบัติการ</title>
    {{-- เรียกใช้ Tailwind CSS ผ่าน CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Sarabun', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen p-6">

    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">ระบบค้นหาขอบข่ายการรับรอง</h1>
            <p class="text-gray-500 text-base mt-2">ค้นหาข้อมูลขอบข่าย</p>
        </div>

        <!-- Search Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
            <form action="{{ url()->current() }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                
                <!-- Keyword Input -->
                <div class="md:col-span-6">
                    <label for="filter_search" class="block text-base font-medium text-gray-700 mb-2">คำค้นหา (ขอบข่าย/รายละเอียด)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               name="filter_search" 
                               id="filter_search" 
                               value="{{ $filter_search ?? '' }}"
                               class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-base" 
                               placeholder="พิมพ์คำที่ต้องการค้นหา เช่น ไฟฟ้า, สอบเทียบ...">
                    </div>
                </div>

                <!-- Type Dropdown -->
                <div class="md:col-span-4">
                    <label for="filter_type" class="block text-base font-medium text-gray-700 mb-2">ประเภทการรับรอง <span class="text-red-500">*</span></label>
                    <select id="filter_type" 
                            name="filter_type" 
                            class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md border bg-white"
                            required>
                        <option value="">กรุณาเลือกรายการ</option>
                        <option value="LAB" {{ (isset($filter_type) && $filter_type == 'LAB') ? 'selected' : '' }}>LAB (ห้องปฏิบัติการ)</option>
                        <option value="IB" {{ (isset($filter_type) && $filter_type == 'IB') ? 'selected' : '' }}>IB (หน่วยตรวจ)</option>
                        <option value="CB" {{ (isset($filter_type) && $filter_type == 'CB') ? 'selected' : '' }}>CB (หน่วยรับรอง)</option>
                    </select>
                </div>

                <!-- Search Button -->
                <div class="md:col-span-2">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        ค้นหาข้อมูล
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
            @if(isset($items) && $items->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-base font-medium text-gray-500 uppercase tracking-wider w-24">
                                    ลำดับ
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-base font-medium text-gray-500 uppercase tracking-wider">
                                    ชื่อการรับรอง / บริษัท
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-base font-medium text-gray-500 uppercase tracking-wider w-56">
                                    เลขที่คำขอ
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($items as $key => $item)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-5 whitespace-nowrap text-lg text-gray-500">
                                        {{ $items->firstItem() + $key }}
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap">
                                        <div class="text-lg font-medium text-gray-900">
                                            {{-- เรียกใช้ property กลาง 'name' --}}
                                            {{ $item->name }}
                                        </div>
                                        <div class="text-sm text-gray-500 mt-1">
                                            {{-- เรียกใช้ property กลาง 'date' --}}
                                            วันที่ยื่น: {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 whitespace-nowrap text-lg text-gray-700">
                                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded">
                                            {{-- เรียกใช้ property กลาง 'app_no' --}}
                                            {{ $item->app_no }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Custom Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-base text-gray-700">
                                แสดง <span class="font-medium">{{ $items->firstItem() }}</span> ถึง <span class="font-medium">{{ $items->lastItem() }}</span> จากทั้งหมด <span class="font-medium">{{ $items->total() }}</span> รายการ
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                @if ($items->onFirstPage())
                                    <span class="relative inline-flex items-center px-3 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-base font-medium text-gray-400 cursor-not-allowed">
                                        <span class="sr-only">Previous</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $items->appends(request()->query())->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 rounded-l-md border border-gray-300 bg-white text-base font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Previous</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @endif

                                @if ($items->hasMorePages())
                                    <a href="{{ $items->appends(request()->query())->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-white text-base font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Next</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @else
                                    <span class="relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-base font-medium text-gray-400 cursor-not-allowed">
                                        <span class="sr-only">Next</span>
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @endif
                            </nav>
                        </div>
                    </div>
                    
                    {{-- Mobile Pagination --}}
                    <div class="flex items-center justify-between sm:hidden w-full">
                        @if ($items->onFirstPage())
                            <span class="relative inline-flex items-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                ก่อนหน้า
                            </span>
                        @else
                            <a href="{{ $items->appends(request()->query())->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                ก่อนหน้า
                            </a>
                        @endif

                        @if ($items->hasMorePages())
                            <a href="{{ $items->appends(request()->query())->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                ถัดไป
                            </a>
                        @else
                            <span class="ml-3 relative inline-flex items-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                                ถัดไป
                            </span>
                        @endif
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    @if(empty($filter_type))
                        {{-- กรณีที่ยังไม่ได้เลือกประเภท --}}
                        <svg class="mx-auto h-16 w-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">กรุณาเลือกประเภทการรับรอง</h3>
                        <p class="mt-2 text-base text-gray-500">เลือกประเภท LAB, IB หรือ CB แล้วกดปุ่มค้นหา</p>
                    @else
                        {{-- กรณีค้นหาแล้วไม่เจอ --}}
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">ไม่พบข้อมูล</h3>
                        <p class="mt-2 text-base text-gray-500">ลองเปลี่ยนคำค้นหาหรือตัวกรอง แล้วลองใหม่อีกครั้ง</p>
                    @endif
                </div>
            @endif
        </div>
    </div>

</body>
</html>