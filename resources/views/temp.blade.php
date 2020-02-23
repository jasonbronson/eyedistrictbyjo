<script
  src="https://code.jquery.com/jquery-1.9.1.min.js"
  ></script>



@foreach($images as $image)
<hr>
<form id="updateaxis{{$image['id']}}"> 
<table class="table-stripped">
<tr>
<td>
    <div>{{$image['sku']}}</div>
    <div>
            <input type="hidden" name="id" value="{{$image['id']}}" size="10">
            bridge<br>
         <a href="#" onclick="rpt.main.bridgeup('updateaxis{{$image['id']}}', event)">UP</a> &nbsp;&nbsp;&nbsp;
         <a href="#"  onclick="rpt.main.bridgedown('updateaxis{{$image['id']}}', event)">Down</a> <input type="hidden" id="arrowsidey" name="arrowside_y" value="{{$image['arrowside_y']}}" size="10">
        <br>
        <br>
         <a href="#"  onclick="rpt.main.bridgeleft('updateaxis{{$image['id']}}', event)">left</a> &nbsp;&nbsp;&nbsp;
         <a href="#"  onclick="rpt.main.bridgeright('updateaxis{{$image['id']}}', event)">Right</a><input type="hidden" id="arrowsidex" name="arrowside_x" value="{{$image['arrowside_x']}}" size="10">
         
         <br>
         <input type="hidden" id="rightsidex" name="rightside_x" value="{{$image['rightside_x']}}" size="10">
         <input type="hidden" id="rightsidey" name="rightside_y" value="{{$image['rightside_y']}}" size="10">
         
    </div>

</td>
<td>
   <img id="image{{$image['id']}}" src="/watermark2.php?filename={{$image['sku']}}_2.jpg&size={{$image['size']}}&arrowup_x={{$image['arrowup_x']}}&arrowup_y={{$image['arrowup_y']}}&arrowside_x={{$image['arrowside_x']}}&arrowside_y={{$image['arrowside_y']}}&leftside_x={{$image['leftside_x']}}&leftside_y={{$image['leftside_y']}}&rightside_x={{$image['rightside_x']}}&rightside_y={{$image['rightside_y']}}">
</td>
</tr>    
</table>
</form>

<script>

        var rpt = rpt || {};

        rpt.main = {
        
            save: function(temp){
        
                $.ajax({
                    url: '/temp/save',
                    method: 'post',
                    data: temp,
                    dataType: 'text',
                    complete: function(e, xhr) {
                        if (e.status === 200) {
                            object = JSON.parse(e.responseText);
        
                            if(object.Error != null){
                                console.log('Error loading resorts');
                            }else{
                                console.log("saved " + temp);
                            }
                            
        
        
                        } else {
                            console.log('Error loading resorts');
                        }
                    }
        
                });
        
            },

            reloadimage: function(imagename, id){

                ///watermark2.php?filename={{$image['sku']}}_2.jpg&size={{$image['size']}}&arrowup_x={{$image['arrowup_x']}}&arrowup_y={{$image['arrowup_y']}}&arrowside_x={{$image['arrowside_x']}}&arrowside_y={{$image['arrowside_y']}}&leftside_x={{$image['leftside_x']}}&leftside_y={{$image['leftside_y']}}&rightside_x={{$image['rightside_x']}}&rightside_y={{$image['rightside_y']}}
                $.ajax({
                    url: '/temp/getimage',
                    method: 'get',
                    data: 'id='+id,
                    dataType: 'json',
                    complete: function(e, xhr) {
                        if (e.status === 200) {
                            o = JSON.parse(e.responseText);
        
                            if(o.Error != null){
                                console.log('Error getting image');
                            }else{       
                                console.log(o);
                                $('#' + imagename).attr("src", "/watermark2.php?filename=" + o.sku + "_2.jpg&size=" + o.size + "&arrowup_x=" + o.arrowup_x + "&arrowup_y=" + o.arrowup_y + "&arrowside_x=" + o.arrowside_x + "&arrowside_y=" + o.arrowside_y + "&leftside_x=" + o.leftside_x + "&leftside_y=" + o.leftside_y + "&rightside_x=" + o.rightside_x + "&rightside_y=" + o.rightside_y );
                            }
        
                        } else {
                            console.log('Error loading resorts');
                        }
                    }
        
                });

                

            },

            changevalue:function(name, increase){

                var val = $(name).val();
                if(increase){
                    val = parseInt(val) + 2;
                }else{
                    val = parseInt(val) - 2;
                }
                
                $(name).val(val);


            },

            saveandreload:function(form, id){

                    var data = $('#' + form).serialize();
                    console.log(data + "***DATAHERE*");
                    rpt.main.save(data);
                    
                    //console.log(id);
                    var imagename='image' + id;
                    rpt.main.reloadimage(imagename, id)


            },

            bridgeleft:function(form, e){
                e.preventDefault();
                var id = $('#' + form).find('input').val();
                rpt.main.changevalue('#' + form + ' #arrowsidex', false);
                rpt.main.changevalue('#' + form + ' #rightsidex', false);
                rpt.main.saveandreload(form, id);      
            },
            bridgeright:function(form, e){
                e.preventDefault();
                var id = $('#' + form).find('input').val();

                rpt.main.changevalue('#' + form + ' #arrowsidex', true);
                rpt.main.changevalue('#' + form + ' #rightsidex', true);
                rpt.main.saveandreload(form, id);      
            },
            bridgeup:function(form, e){
                e.preventDefault();
                var id = $('#' + form).find('input').val();
            
                rpt.main.changevalue('#' + form + ' #arrowsidey', false);
                rpt.main.changevalue('#' + form + ' #rightsidey', false);
                rpt.main.saveandreload(form, id);      
            },
            bridgedown:function(form, e){
                e.preventDefault();
                var id = $('#' + form).find('input').val();

                rpt.main.changevalue('#' + form + ' #arrowsidey', true);
                rpt.main.changevalue('#' + form + ' #rightsidey', true);
                rpt.main.saveandreload(form, id);      
            },

        
            /* //!Initialize Function
             ------------------------------*/
            initialize: function() {
        
                
        
                /*$('body').on('click', '#bridgeleft', function(e) {
                    e.preventDefault();
                    
                    var form = $(this).closest('form').attr('id');
                    rpt.main.changevalue('#' + form + ' #arrowsidex', false);
                    rpt.main.changevalue('#' + form + ' #rightsidex', false);
                    
                    var id = $(this).closest('form').find('input').val();
                    rpt.main.saveandreload(form, id);

                });
                $('body').on('click', '#bridgeright', function(e) {
                    e.preventDefault();
                    
                    var form = $(this).closest('form').attr('id');
                    rpt.main.changevalue('#' + form + ' #arrowsidex', true);
                    rpt.main.changevalue('#' + form + ' #rightsidex', true);
                    //var rightsidex = $('#' + form + ' #rightsidex').val();

                    var id = $(this).closest('form').find('input').val();
                    rpt.main.saveandreload(form, id);

                });
    
                $('body').on('click', '#bridgeup', function(e) {
                    e.preventDefault();
                    
                    var form = $(this).closest('form').attr('id');
                    rpt.main.changevalue('#' + form + ' #arrowsidey', false);
                    rpt.main.changevalue('#' + form + ' #rightsidey', false);
                    
                    var id = $(this).closest('form').find('input').val();
                    rpt.main.saveandreload(form, id);

                });
                $('body').on('click', '#bridgedown', function(e) {
                    e.preventDefault();
                    
                    var form = $(this).closest('form').attr('id');
                    rpt.main.changevalue('#' + form + ' #arrowsidey', true);
                    rpt.main.changevalue('#' + form + ' #rightsidey', true);
                    
                    var id = $(this).closest('form').find('input').val();
                    rpt.main.saveandreload(form, id);

                });
    */
        
                $(document).ajaxStart(function() {
                    console.log("ajax start");
                    $(".loading").show();
                });
        
                $(document).ajaxStop(function() {
                    $(".loading").hide();
                });
        
        
        
            }
        
        };
        
        //fire all engines!
        $().ready(function() {
            rpt.main.initialize();
            
        });

        

        

</script>    

 @endforeach