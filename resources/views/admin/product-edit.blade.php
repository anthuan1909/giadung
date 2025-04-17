@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Chỉnh sửa sản phẩm</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}">
                        <div class="text-tiny">Thống kê</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{route('admin.products')}}">
                        <div class="text-tiny">Sản phẩm</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Chỉnh sửa sản phẩm</div>
                </li>
            </ul>
        </div>
        <!-- form-add-product -->
        <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{route('admin.product.update')}}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $product->id }}">
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Tên sản phẩm <span class="tf-color-1">*</span>
                    </div>
                    <input class="mb-10" type="text" placeholder="Nhập tên sản phẩm" name="name" tabindex="0" value="{{ $product->name }}" aria-required="true" required="">
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                </fieldset>
                @error('name') <span class="alert alert-danger text-center">{{$message}} @enderror

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Danh mục <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="category_id">
                                <option>Chọn danh mục</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{$product->category_id == $category->id ? "selected":""}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error('category_id') <span class="alert alert-danger text-center">{{$message}} @enderror


                    <fieldset class="brand">
                        <div class="body-title mb-10">Nhà sản xuất <span class="tf-color-1">*</span>
                        </div>
                        <div class="select">
                            <select class="" name="producer_id">
                                <option>Chọn nhà sản xuất</option>
                                @foreach($producers as $producer)
                                <option value="{{$producer->id}}" {{$product->producer_id == $producer->id ? "selected":""}}>{{$producer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>
                    @error('producer_id') <span class="alert alert-danger text-center">{{$message}} @enderror

                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Mô tả ngắn</div>
                    <textarea class="mb-10 ht-150" name="short_description" placeholder="Mô tả ngắn về sản phẩm" tabindex="0">{{ old('short_description') }}</textarea>
                </fieldset>
                @error('short_description') <span class="alert alert-danger text-center">{{$message}} @enderror


                <fieldset class="description">
                    <div class="body-title mb-10">Mô tả <span class="tf-color-1">*</span>
                    </div>
                    <textarea class="mb-10" name="description" id="editor" placeholder="Mô tả sản phẩm" required="">{{$product->description}}</textarea>
                </fieldset>
                @error('description') <span class="alert alert-danger text-center">{{$message}} @enderror

                <fieldset>
                    <div class="body-title">Ảnh chính<span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        @if($product->image)
                        <div class="item" id="imgpreview">
                            <img src="{{asset('uploads/products')}}/{{$product->image}}" class="effect8" alt="{{$product->name}}">
                        </div>
                        @endif
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <span class="alert alert-danger text-center">{{$message}} @enderror

            </div>
            <div class="wg-box">
                <fieldset>
                    <div class="body-title mb-10">Ảnh phụ</div>
                    <div class="upload-image mb-16">
                        @if($product->images)
                            @foreach(explode(',',$product->images) as $img)
                                <div class="item gitems">
                                    <img src="{{asset('uploads/products')}}/{{trim($img)}}" alt="">
                                </div>
                            @endforeach
                        @endif
                        <div id="galUpload" class="item up-load">
                            <label class="uploadfile" for="gFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="text-tiny">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="gFile" name="images[]" accept="image/*" multiple="">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('images') <span class="alert alert-danger text-center">{{$message}} @enderror
                
                @if(!$product->has_variants)
                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Mã sản phẩm <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" name="SKU" value="{{$product->SKU}}" required>
                    </fieldset>
                </div>
                
                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Kích thước <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" name="size" value="{{$product->size}}" required>
                    </fieldset>
                    
                    <fieldset class="name">
                        <div class="body-title mb-10">Màu sắc <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" name="color" value="{{$product->color}}" required>
                    </fieldset>
                    
                    <fieldset class="name">
                        <div class="body-title mb-10">Số lượng <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="number" name="quantity" value="{{$product->quantity}}" required>
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Giá nhập <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" name="import_price" value="{{$product->import_price}}" required>
                    </fieldset>
                    
                    <fieldset class="name">
                        <div class="body-title mb-10">Giá bán <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" name="regular_price" value="{{$product->regular_price}}" required>
                    </fieldset>
                    
                    <fieldset class="name">
                        <div class="body-title mb-10">Giảm giá (%)</div>
                        <input class="mb-10" type="text" name="sale" value="{{$product->sale}}">
                    </fieldset>
                </div>

                @else
                    @foreach($variants as $variant)
                
                        <div class="cols gap22">
                            <input type="hidden" name="variant_id[]" value="{{$variant->id}}">
                            <fieldset class="name">
                                <div class="body-title mb-10">Mã sản phẩm <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="text" name="variant_sku[]" value="{{$variant->SKU}}" required>
                            </fieldset>
                        </div>
                            
                        <div class="cols gap22">
                            <fieldset class="name">
                                <div class="body-title mb-10">Kích thước <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="text" name="variant_size[]" value="{{$variant->size}}" required>
                            </fieldset>
                            
                            <fieldset class="name">
                                <div class="body-title mb-10">Màu sắc <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="text" name="variant_color[]" value="{{$variant->color}}" required>
                            </fieldset>
                            
                            <fieldset class="name">
                                <div class="body-title mb-10">Số lượng <span class="tf-color-1">*</span></div>
                                <input class="mb-10" type="number" name="variant_quantity[]" value="{{$variant->quantity}}" required>
                            </fieldset>
                        </div>   

                        <div class="cols gap22">
                                <fieldset class="name">
                                    <div class="body-title mb-10">Giá nhập <span class="tf-color-1">*</span></div>
                                    <input class="mb-10" type="text" name="variant_import_price[]" value="{{$variant->import_price}}" required>
                                </fieldset>
                                
                                <fieldset class="name">
                                    <div class="body-title mb-10">Giá bán <span class="tf-color-1">*</span></div>
                                    <input class="mb-10" type="text" name="variant_regular_price[]" value="{{$variant->regular_price}}" required>
                                </fieldset>
                                
                                <fieldset class="name">
                                    <div class="body-title mb-10">Giảm giá (%)</div>
                                    <input class="mb-10" type="text" name="variant_sale[]" value="{{$variant->sale}}">
                                </fieldset>
                        </div>
                    @endforeach
                @endif



                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Trạng thái</div>
                        <div class="select mb-10">
                            <select class="" name="stock_status">
                                <option value="instock" {{$product->stock_status == "instock" ? "selected":""}}>Còn hàng</option>
                                <option value="outofstock" {{$product->stock_status == "outofstock" ? "selected":""}}>Hết hàng</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('stock_status') <span class="alert alert-danger text-center">{{$message}} @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Nổi bật</div>
                        <div class="select mb-10">
                            <select class="" name="featured">
                                <option value="0" {{$product->featured == "0" ? "selected":""}}>Không</option>
                                <option value="1" {{$product->featured == "1" ? "selected":""}}>Có</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('featured') <span class="alert alert-danger text-center">{{$message}} @enderror

                </div>
                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Cập nhật</button>
                </div>
            </div>
        </form>
        <!-- /form-add-product -->
    </div>
    <!-- /main-content-wrap -->
</div>

@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/4.20.0/full/ckeditor.js"></script>
<script src="{{asset ('assets/js/editor.js') }}"></script>
    <script>
        $(function(){
            $("#myFile").on("change",function(e){
                const photoInp = $("#myFile");
                const [file] = this.files;
                if(file){
                    $("#imgpreview img").attr('src',URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });

            $("#gFile").on("change",function(e){
                const photoInp = $("#gFile");
                const gphotos = this.files;
                $.each(gphotos,function(key,val){
                    $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}" /></div>`);
                });
                
            });

            $("input[name='name']").on("change",function(){
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });

        });

        function StringToSlug(text){
            return Text.toLowerCase()
            .replace(/[^\w ]+/g,"")
            .replace(/ +/g,"-");
        }
    </script>
@endpush