<style>
    .isic-table {
        width: 690px;
        border-collapse: collapse;
        font-family: "TH Sarabun New", sans-serif;
        font-size: 16px;
    }
    .isic-table th, .isic-table td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
    .isic-table th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: center;
        font-size: 20px;
    }

    .isic-code {
        width: 20%;
        text-align: center;
        font-weight: bold;
    }
    .description {
        width: 80%;
    }
    .sub-text {
        font-size: 14px;
        font-style: italic;
    }
</style>
{{-- {{$cbScopeIsicTransactions->count()}} --}}
    <table class="isic-table" style="margin-top: 20px">
        <tr>
            <th class="isic-code">รหัส ISIC<br><span style="font-size: 16px; font-weight: normal;">(ISIC Codes)</span></th>
            <th class="description">กิจกรรม<br><span style="font-size: 16px; font-weight: normal;">(Description)</span></th>
        </tr>
   
        @foreach ($cbScopeIsicTransactions as $key => $cbScopeIsicTransaction)
      
            <tr>
                
                @php

                    $categoryCodes = "";
                    $subCategoryCodesFiltered = "";


                    $filteredCategoryTransactions = $cbScopeIsicTransaction->cbScopeIsicCategoryTransactions->where('is_checked', 1);
                    $filteredCategories = $cbScopeIsicTransaction->cbScopeIsicCategories();
                    $excludedCategoryIds = $filteredCategories->pluck('id')->diff($filteredCategoryTransactions->pluck('category_id'));
                    // $excludedCategoryCodes = $filteredCategories->whereIn('id', $excludedCategoryIds)->pluck('category_code');

                    $excludedCategoryCodes = $filteredCategories
                        ->whereIn('id', $excludedCategoryIds)
                        ->pluck('category_code')
                        ->map(function ($code) {
                            return str_pad($code, 3, '0', STR_PAD_LEFT);
                        })
                        ->toArray(); // แปลงเป็น array ทันที

                    // $categoryCodes = $excludedCategoryCodes->map(function($excludedCategoryCodes) {
                    //     return str_pad($excludedCategoryCodes, 3, '0', STR_PAD_LEFT);
                    // })->implode(', ');

                    // $allExcludedSubCategoryCodes = [];
                    // foreach ($filteredCategoryTransactions as $key => $filteredCategoryTransaction) {
                    //     $cbScopeIsicSubCategoryTransactions = $filteredCategoryTransaction->cbScopeIsicSubCategoryTransactions;                        
                    //     if ($cbScopeIsicSubCategoryTransactions->count() != 0) {
                    //         $excludedSubCategoryIds = $filteredCategoryTransaction->cbScopeIsicSubCategories()->pluck('id')->diff($cbScopeIsicSubCategoryTransactions->pluck('subcategory_id'));
                    //         $excludedSubCategoryCodes = $filteredCategoryTransaction->cbScopeIsicSubCategories()->whereIn('id', $excludedSubCategoryIds)->pluck('sub_category_code');
                    //         $allExcludedSubCategoryCodes = array_merge($allExcludedSubCategoryCodes, $excludedSubCategoryCodes->toArray());
                    //     }
                    // }
                    
                    $allExcludedSubCategoryCodes = [];
                    foreach ($filteredCategoryTransactions as $key => $filteredCategoryTransaction) {
                        $cbScopeIsicSubCategoryTransactions = $filteredCategoryTransaction->cbScopeIsicSubCategoryTransactions;                        
                        if ($cbScopeIsicSubCategoryTransactions->count() != 0) {
                            $excludedSubCategoryIds = $filteredCategoryTransaction->cbScopeIsicSubCategories()->pluck('id')->diff($cbScopeIsicSubCategoryTransactions->pluck('subcategory_id'));
                            $excludedSubCategoryCodes = $filteredCategoryTransaction->cbScopeIsicSubCategories()
                                ->whereIn('id', $excludedSubCategoryIds)
                                ->pluck('sub_category_code')
                                ->map(function ($code) {
                                    return str_pad($code, 4, '0', STR_PAD_LEFT);
                                })
                                ->toArray();
                            $allExcludedSubCategoryCodes = array_merge($allExcludedSubCategoryCodes, $excludedSubCategoryCodes);
                        }
                    }
                    $combinedCodes = array_merge($excludedCategoryCodes, $allExcludedSubCategoryCodes);
                    // $categoryCodes = $combinedCodes->implode(', ');
                    
                    $combinedCodesString = implode(', ', $combinedCodes);
                    // dd($combinedCodesString);


                    // สร้าง $subCategoryCodesFiltered โดยไม่ทับซ้อนตัวแปร
                    $subCategoryCodesFiltered = $filteredCategoryTransactions->flatMap(function($categoryTransaction) {
                        // กรอง subCategoryTransactions ที่ is_checked = 0
                        return $categoryTransaction->cbScopeIsicSubCategoryTransactions->filter(function($subCategoryTransaction) {
                            return $subCategoryTransaction->is_checked == 0;
                        })->map(function($subCategoryTransaction) {
                            // เติม 0 ให้เป็น 4 หลัก
                            return str_pad($subCategoryTransaction->cbScopeIsicSubCategory->sub_category_code, 4, '0', STR_PAD_LEFT);
                        });
                    })->implode(', ');

                    // รวม $categoryCodes และ $subCategoryCodesFiltered ใส่คอมมา
                    $combinedCodes = $combinedCodesString;

                @endphp

                <td class="isic-code" style="text-align: center;font-size:22px; font-weight: normal;">{{$cbScopeIsicTransaction->isic->isic_code}} 
                    {{-- {{$cbScopeIsicTransaction->cbScopeIsicCategoryTransactions}} --}}
                    @if ($combinedCodes != "" )
                    <br> (ยกเว้น {{$combinedCodes}} )
                    @endif

                     <span style="font-size: 0.01px">*{{$key}}*</span>
                </td>
                <td class="description" style="font-size:22px">

                    {{$cbScopeIsicTransaction->isic->description_th}}<br>
                    <span class="sub-text">({{$cbScopeIsicTransaction->isic->description_en}})</span>
                </td>
            </tr>
        @endforeach
    </table>


    
</div>
