                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="seachByBrand">Brand</label>
                            <select class="form-control seachByBrand" id="" wire:model="filterBrand">
                                <option value="">-Select-</option>
                                @foreach($itemfilterBrands as $qlBrand)
                                <option value="{{$qlBrand->BrandId}}">{{$qlBrand->Description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="seachByCategory">Category</label>
                            <select class="form-control seachByCategory" id="" wire:model="filterCategory">
                                <option value="">-Select-</option>
                                @foreach($itemfilterCategories as $itemQlCategory)
                                <option value="{{$itemQlCategory->CategoryId}}">{{$itemQlCategory->Description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="seachBySubCategory">Sub Category</label>
                            <select class="form-control seachBySubCategory" id="" wire:model="filterSubCategory">
                                <option value="">-Select-</option>
                                @foreach($itemfilterSubCategories as $itemQlSubCategory)
                                <option value="{{$itemQlSubCategory->SubCategoryId}}">{{$itemQlSubCategory->Description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>