                
            <div class="cateringpopup">
                <input type="hidden" name="item_id" id="item_id" value="{{$getitem->id}}">

                 @foreach ($getitem->variation as $key => $value)
                        <input type="hidden" name="price" id="price" value="{{($getitem->is_default_combo != 1) ? $value->product_price : ($value->product_price + $totalComboPrice)}}">
                        @break
                    @endforeach
                    <div class="row title-price">
                    <div class="col-md-9">
                        <h3>{{$getitem->item_name}}</h3> 
                       <p>{{ Str::limit($getitem->item_description, 200) }}</p>
                       </div>
                    <div class="col-md-3">
                       <p class="pricing">
                            @foreach ($getitem->variation as $key => $value)

                                <h3 id="temp-pricing" class="temp-pricing product-price">{{$getdata->currency}}{{($getitem->is_default_combo != 1) ? number_format($value->product_price,2) : number_format($value->product_price + $totalComboPrice , 2)}}</h3>
                                @if ($value->sale_price > 0)
                                    <h3 id="card2-oldprice">{{$getdata->currency}}{{number_format($value->sale_price,2)}}</h3>
                                @endif
                                @break
                            @endforeach
                            <p class="card2-oldprice-show"></p>
                            @if($getitem->tax > 0)
                                <p style="color: #ff0000;" class="mt-3">+ {{$getitem->tax}}% Additional Tax</p>
                            @else
                                <p style="color: #03a103;" class="mt-3">Inclusive of all taxes</p>
                            @endif
                        </p> 
                    </div>
                    
                        @if (count($getitem['variation']) > 1)
                        <div class="col-md-6">
                    <label>{{ trans('messages.select_variation') }}</label>
                    <select class="form-control readers" name="variation" id="variation">
                        @foreach($getitem['variation'] as $key => $variation)
                            <option value="{{$variation->id}}" data-price="{{$variation->product_price}}" data-saleprice="{{$variation->sale_price}}" data-variation="{{$variation->variation}}">{{$variation->variation}}</option>
                        @endforeach
                    </select>
                    </div>
                @else

                    <select class="form-control readers" name="variation" id="variation" style="display: none;">
                        @foreach($getitem['variation'] as $key => $variation)
                            <option value="{{$variation->id}}" data-price="{{$variation->product_price}}" data-saleprice="{{$variation->sale_price}}" data-variation="{{$variation->variation}}">{{$variation->variation}}</option>
                        @endforeach
                    </select>

                @endif
                    
                    <div class="col-md-6">
                        <label>Select Quantity</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="1000" class="quantity form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Date & Time</label>
                        <input type="datetime-local" name="calendar" id="calendar" class="quantity form-control">
                    </div>
                   </div>
                   <div class="alert alert-danger" style="display: none;" id="AddToCartError"></div>
                             <div class="extra-food-wrap addons-box">

                        

    <ul class="col-md-12 nav nav-tabs">
      @if (isset($getingredientsByTypes[0]->name))
          <li><a class="active" data-toggle="tab" href="#ingredients">Ingredients</a></li>
      @endif
      @if (isset($getAddonsByGroups[0]->name))
          <li><a class="{{(isset($getingredientsByTypes[0]->name)) ? '' : 'active'}}" data-toggle="tab" href="#free">Free Add-on</a></li>
      @endif

      @if (isset($getAddonsByGroups[0]->name))
      <li><a data-toggle="tab" href="#paid">Paid Add-on</a></li>
      @endif
      @if (isset($ComboGroups[0]->name)) 
      <li class="combotab" style="{{($getitem->is_default_combo != 1) ? 'display: none;' : '' }}"><a data-toggle="tab" href="#combocontent" >Combo</a></li>
      @endif
    </ul>

    <div class="col-md-12 tab-content main-tab-content">
                        
            <!-- Ingredients start -->
            <div id="ingredients" class="tab-pane in active">
                <div class="col-md-12 w3-bar w3-black tab">
            @if (isset($getingredientsByTypes[0]->name))
                    <!-- <div id="ingredientsOptions" class="ingredientsOptions">  -->
                    @foreach($getingredientsByTypes as $ingredientsByType)
                    <!-- <button class="w3-bar-item w3-button" onclick="openCity('{{$ingredientsByType->name}}')">{{$ingredientsByType->name}}</button> -->
                    <div class="ingredientsWrapper" option-allowed="{{$ingredientsByType->available_ing_option}}">
                    <div class="w3-bar-item w3-button addons-tabs-cart" onclick="openCity('{{$ingredientsByType->name}}')">
                       <h3>{{$ingredientsByType->name}}</h3> 
                       <p>You can select {{$ingredientsByType->available_ing_option}} option<?php echo ($ingredientsByType->available_ing_option > 1 || $ingredientsByType->available_ing_option == 'all')? 's' : '' ; ?>.</p>
                       <span class="required_label">Required</span>

                    </div>
                    <div id="{{$ingredientsByType->name}}" class="addon tabcontent"  >
                        <div class="selectIngredients" >                                        
                            
                             <ul class="list-unstyled extra-food" ingredient_type="{{$ingredientsByType->name}}">
                             @foreach($ingredientsByType->ingredients as $ingredientsItems)
                            <li class="{{($ingredientsByType->available_ing_option > 1 || $ingredientsByType->available_ing_option == 'all')? '' : 'Radio'}}">
                                <input  class="Checkbox ingredients" type="{{($ingredientsByType->available_ing_option > 1 || $ingredientsByType->available_ing_option == 'all')? 'checkbox' : 'radio'}}" name="ingredients['{{$ingredientsByType->name}}']" value="{{$ingredientsItems->ingredients}}" data-option-allowed="{{$ingredientsByType->available_ing_option}}" ingredient_name="{{$ingredientsItems->ingredients}}" >
                                <p>{{$ingredientsItems->ingredients}}</p>
                            </li>
                             @endforeach
                             </ul>
                         </div>
                    </div>
                    </div>
                    @endforeach
                    <!-- </div> -->
            @endif
            </div>
            </div>
            <!-- End Ingredients -->    
            <!-- ------Paid group addon start----- -->  
                <!-- Paid Group Addon -->
                <div id="free" class="tab-pane fade">
                    <div class="col-md-12 w3-bar w3-black tab">
               
            <!-- ------free group start---- -->
            <!--  Free Group Addon -->
                    @if (isset($getAddonsByGroups[0]->name)) 
                   
                        @foreach ($getAddonsByGroups as $getAddonsByGroup)
                         @if ($getAddonsByGroup->price == 0)
                         <div class="group_addon_wrapper">
                         <div class="w3-bar-item w3-button addons-tabs-cart" onclick="openCity('{{$getAddonsByGroup->name}}{{$getAddonsByGroup->id}}free')">
                       <h3>{{$getAddonsByGroup->name}}</h3> 
                       <p>You can select {{$getAddonsByGroup->available_add_option}} option<?php echo ($getAddonsByGroup->available_add_option > 1 || $getAddonsByGroup->available_add_option == 'all')? 's' : '' ; ?>.</p>
                        </div>
                            <div id="{{$getAddonsByGroup->name}}{{$getAddonsByGroup->id}}free" class="addon tabcontent" style="display:none">
                            <ul class="list-unstyled extra-food addon_group" group_name="{{$getAddonsByGroup->name}}"  data-currency="{{$getdata->currency}}" data-price="{{$getAddonsByGroup->price}}">
                                 
                                @foreach($getAddonsByGroup->addons as $addon)
                                    <li class="{{($getAddonsByGroup->available_add_option > 1 || $getAddonsByGroup->available_add_option == 'all')? '' : 'Radio'}}">
                                        <input type="{{($getAddonsByGroup->available_add_option > 1 || $getAddonsByGroup->available_add_option == 'all')? 'checkbox' : 'radio'}}" name="addons['{{$getAddonsByGroup->name}}'][]" class="Checkbox group_addon" value="{{$addon->name}}" data-option-allowed="{{$getAddonsByGroup->available_add_option}}"  addon_name="{{$addon->name}}">
                                        <p>{{$addon->name}}</p>
                                    </li>
                                @endforeach
                                </ul>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @endif

            <!-- ------free group end---- -->
            <!-- ---------free group addon start---- -->   
                    <!-- Free Single Addon -->
                    @if (count($freeaddons['value']) != 0)
                     <!-- <button >{{ trans('labels.free_addons') }}</button> -->

                     <div class="w3-bar-item w3-button addons-tabs-cart" onclick="openCity('{{ trans('labels.free_addons') }}')">
                       <h3>{{ trans('labels.free_addons') }}</h3> 
                        <p>Select Additional Add-ons</p>
                        </div>

                     <div id="{{ trans('labels.free_addons') }}" class="addon tabcontent" style="display:none"> 
                        <ul class="list-unstyled extra-food single-addon">
                            @if ($freeaddons['value'] != "")
                                @foreach ($freeaddons['value'] as $addons)
                                <li>
                                    <input type="checkbox" name="addons[]" class="Checkbox single_addon" value="{{$addons->id}}" price="{{$addons->price}}" addons_name="{{$addons->name}}">
                                    <p>{{$addons->name}}</p>
                                </li>
                                @endforeach
                            @else

                            @endif
                        </ul>
                        </div>
                    @endif
                    </div>
                    </div>
                    <!-- End Free Single Addon -->
            <!-- ---------free group addon end---- -->
            <!-- -----free single addon start---- -->
            <div id="paid" class="tab-pane fade">
                <div class="col-md-12 w3-bar w3-black tab">
                     @if (isset($getAddonsByGroups[0]->name))
                    @foreach ($getAddonsByGroups as $getAddonsByGroup)
                        @if ($getAddonsByGroup->price != 0)

                   <!--  <button class="w3-bar-item w3-button" onclick="openCity('{{$getAddonsByGroup->name}}{{$getAddonsByGroup->id}}paid')">{{$getAddonsByGroup->name}} : {{$getdata->currency}}{{number_format($getAddonsByGroup->price, 2)}}</button> -->

                   <div class="group_addon_wrapper">
                    <div class="w3-bar-item w3-button addons-tabs-cart" onclick="openCity('{{$getAddonsByGroup->name}}{{$getAddonsByGroup->id}}paid')">
                        <h3>{{$getAddonsByGroup->name}} : {{$getdata->currency}}{{number_format($getAddonsByGroup->price, 2)}}</h3>
                        <p>You can select {{$getAddonsByGroup->available_add_option}} option<?php echo ($getAddonsByGroup->available_add_option > 1 || $getAddonsByGroup->available_add_option == 'all')? 's' : '' ; ?>.</p>
                    </div>
                    <div id="{{$getAddonsByGroup->name}}{{$getAddonsByGroup->id}}paid" class="addon tabcontent" style="display:none">
                        <ul class="list-unstyled extra-food addon_group paid" data-currency="{{$getdata->currency}}" data-price="{{$getAddonsByGroup->price}}" group_name="{{$getAddonsByGroup->name}}">
                            
                            @foreach($getAddonsByGroup->addons as $addon)
                                <li class="{{($getAddonsByGroup->available_add_option > 1 || $getAddonsByGroup->available_add_option == 'all')? '' : 'Radio'}}">
                                    <input type="{{($getAddonsByGroup->available_add_option > 1 || $getAddonsByGroup->available_add_option == 'all')? 'checkbox' : 'radio'}}" name="addons['{{$getAddonsByGroup->name}}'][]" class="Checkbox group_addon" value="{{$addon->name}}" data-option-allowed="{{$getAddonsByGroup->available_add_option}}" addon_name="{{$addon->name}}">
                                    <p>{{$addon->name}}</p>
                               </li>
                            @endforeach
                        </ul>
                    </div>   
                    </div> 
                        @endif
                    @endforeach
                @endif 
                
            <!-- End Paid Group Addon -->
                        <!-- Paid Single Addon --> 
                    @if (count($paidaddons['value']) != 0)
                    <!-- <button class="w3-bar-item w3-button addons-tabs-cart" onclick="openCity('{{ trans('labels.paid_addons') }}')"></button> -->

                    <div class="w3-bar-item w3-button addons-tabs-cart" onclick="openCity('{{ trans('labels.paid_addons') }}')">
                        <h3>{{ trans('labels.paid_addons') }}</h3>
                        <p>Select Additional Add-ons</p>
                    </div>

                    <div id="{{ trans('labels.paid_addons') }}" class="addon tabcontent" style="display:none">
                        <ul class="list-unstyled extra-food single-addon">
                            <div id="pricelist">
                            @foreach ($paidaddons['value'] as $addons)
                            <li>
                                <input type="checkbox" name="addons[]" class="Checkbox single_addon" value="{{$addons->id}}" price="{{$addons->price}}" addons_name="{{$addons->name}}">
                                <p>{{$addons->name}} : {{$getdata->currency}}{{number_format($addons->price, 2)}}</p>
                            </li>
                            @endforeach
                            </div>
                        </ul>
                        </div>
                    @endif
            </div>   
            </div>
                    <!-- End Paid Single Addon -->
        <!-- -----free single addon end---- -->
        
       
    </div>
    </div>
                    
                    