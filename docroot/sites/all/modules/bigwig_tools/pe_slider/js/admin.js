jQuery(document).ready(function (e) {
    jQuery.fn.exists = function () {
        return this.length > 0
    };
    
    e('table td a:contains("export")').parent().remove();
    e('#edit-label-machine-name-suffix').remove();
    
    if (e(".field-type-pe-slider-layer").exists()) {
        $video = e(".dimensions" ).data( "video" );
        if($video != 0) {
    		if(e('.field-name-field-image').exists()) { e('.field-name-field-image').remove(); }
        	e('.dimensions').before('<div style="margin-top: 20px;" class="messages status"><strong>Notice:</strong> Video is enabled for this slider. All images for the slide builder will use the image uploaded to the "video fallback" field for this slider.</strong>');
        }
        if($video == 0) {
        	var t = e(".field-name-field-image .image-widget span.file").find("a").attr("href");
        } else {
        	var t = $video;
    	}
        $subLayer = e(".field-type-pe-slider-layer table.field-multiple-table tr.draggable:not(:last)");
        $first = e(".field-type-pe-slider-layer table.field-multiple-table tr.draggable:first");
        $last = e(".field-type-pe-slider-layer table.field-multiple-table tr.draggable:last");
        $current = 0;
        $width = e(".dimensions" ).data( "width" );
        $height = e(".dimensions" ).data( "height" );
        $maxHeight = e(".dimensions" ).data( "max-height" );
        $margin = ($maxHeight - $height) / 2;
        e(".field-type-pe-slider-layer").before('<div class="preview-bg peSlider" />');
        e("div.preview-bg").wrap('<div class="slide-builder" />');
        e(".slide-builder").prepend("<label>Preview</label>");
        e("div.preview-bg").wrap('<div class="preview-wrap" />');
        var n = new Image;
        n.onload = function () {
            e(".slide-builder").width(e(".slide-builder").parent().width());
            e("div.preview-bg").css("width", $width).css("height", $height);
            e("div.preview-bg").wrapInner('<div class="peCaption" />');
            e("div.preview-wrap").css("background-image", "url(" + t + ")").css("width", '100%').css("height", $maxHeight).css("background-position", "center").css('paddingTop', $margin).css('marginBottom', -$margin);
            e("div.peCaption").css("width", $width).css("height", $height);
            if (this.width > e("slide-builder").parent().width()) {}
        };
        n.src = t;
        $first.show();
        $last.hide();
        $subLayer.each(function () {
            var t = e(this).find("input.edit-pe_slider-fields-data-x").val();
            $y = e(this).find("input.edit-pe_slider-fields-data-y").val();
            $i = $current++;
            $slideWrap = e(".slide-builder").find("div.preview-bg");
            $selected = e(this).find("select.form-select");
            $img = e(this).find(".form-managed-file span.file").find("a").attr("href");
            $div = e(this).find(".edit-pe_slider-fields-markup-" + $i);
            $css = e(this).find("input.edit-pe_slider-fields-css-" + $i).val();
            $cssField = e(this).find(".edit-pe_slider-fields-css-" + $i);
            e(this).find("input.edit-pe_slider-fields-data-x").addClass("layer-x-" + $i + "-draggable");
            e(this).find("input.edit-pe_slider-fields-data-y").addClass("layer-y-" + $i + "-draggable");
            e(this).find("select.edit-pe_slider-fields-layer-"+$i).addClass("select-" + $i + "-menu");

            $slideWrap.append('<div class="layer layer-' + $i + '-editor ' +$css+'" style="left: '+t+'px; top: ' + $y + 'px"></div>');
            console.log('<div class="layer layer-' + $i + '-editor ' +$css+'" style="left: '+t+'px; top: ' + $y + 'px"></div>');
            switch ($selected.val()) {
	            case "img":
	                if ($img == undefined) {
	                    e(".layer-" + $i + "-editor").html("New Image")
	                } else {
	                    e(".layer-" + $i + "-editor").html('<img class="' + $css + '" src="' + $img + '" />')
	                }
	            break;
	            case "div": e(".layer-" + $i + "-editor").html($div.val()); break;
	            default: e(".layer-" + $i + "-editor").html("New Layer"); break; 
            }
            
            var n = e(this).index();
            e(".select-" + n + "-menu").change(function () {
                $img = e(this).parents().eq(2).find(".form-managed-file span.file").find("a").attr("href");
                $div = e(this).parents().eq(3).find(".edit-pe_slider-fields-markup-" + n);
                $css = 'tp-caption '+e(this).parents().eq(3).find("input.edit-pe_slider-fields-css-" + n).val();
                switch (e(this).val()) {
                case "img":
                    if ($img == undefined) {
                        e(".layer-" + n + "-editor").html("New Image")
                    } else {
                        e(".layer-" + n + "-editor").html('<img class="' + $css + '" src="' + $img + '" />')
                    }
                    break;
                case "div":
                    e(".layer-" + n + "-editor").html('<div class="' + $css + '">' + $div.val() + "</div>");
                    break;
                default:
                    e(".layer-" + n + "-editor").html("New Layer");
                    break
                }
            });
            e(".layer-" + n + "-editor").draggable({
                cursor: "crosshair",
                containment: "parent",
                stop: function (t, r) {
                    var i = $slideWrap.offset();
                    $pos = r.helper.offset();
                    e(".layer-x-" + n + "-draggable").val(($pos.left - i.left).toFixed(0));
                    e(".layer-y-" + n + "-draggable").val(($pos.top - i.top).toFixed(0))
                }
            });
            e("input.layer-x-" + n + "-draggable").keyup(function () {
                e(".layer-" + n + "-editor").css("left", e(this).val() + "px")
            });
            e("input.layer-y-" + n + "-draggable").keyup(function () {
                e(".layer-" + n + "-editor").css("top", e(this).val() + "px")
            });
            
        	$old = $cssField.val();
            $cssField.keyup(function (t) {
                $value = 'tp-caption '+e(this).val();
                t = $value;
                switch (e(".select-" + n + "-menu").val()) {
                case "img":
                    e(".layer-" + n + "-editor").removeClass($old).addClass($value);
                    break;
                case "div":
                    e(".layer-" + n + "-editor").removeClass($old).addClass($value);
                    break
                }
                $old = $value;
            });
            
            $div.keyup(function () {
                e(".layer-" + n + "-editor").text(e(this).val())
            })
        });
        Drupal.behaviors.pe_slider = {
            attach: function (t, n) {
                $last.show();
                $last = e(".field-type-pe-slider-layer table.field-multiple-table tr.draggable:last");
                $subLayer = e(".field-type-pe-slider-layer table.field-multiple-table tr.draggable:not(:last)");
                $index = $last.index() - 1;
                $last.hide();
                e(".field-name-field-layer-settings input.field-add-more-submit", t).once("pe_slider", function () {
                    $subLayer.each(function () {
                        $i = e(this).index();
                        e(this).find("input.edit-pe_slider-fields-data-x").addClass("layer-x-" + $i + "-draggable");
                        e(this).find("input.edit-pe_slider-fields-data-y").addClass("layer-y-" + $i + "-draggable");
                        e(this).find("select.edit-pe_slider-fields-layer-"+$i).addClass("select-" + $i + "-menu");
                        $slideWrap = e(".slide-builder").find("div.preview-bg");
                        $div = e(this).find(".edit-pe_slider-fields-markup-" + $i);
                        $css = e(this).find("input.edit-pe_slider-fields-css-" + $i).val();
                        $cssField = e(this).find(".edit-pe_slider-fields-css-" + $i);
                        
                        var t = e(this).index();
                        
                        e(".select-" + t + "-menu").change(function () {
                            $img = e(this).parents().eq(2).find(".form-managed-file span.file").find("a").attr("href");
                            $div = e(this).parents().eq(3).find(".edit-pe_slider-fields-markup-" + t);
                            $css = 'tp-caption '+e(this).parents().eq(3).find("input.edit-pe_slider-fields-css-" + t).val();
                            switch (e(this).val()) {
                            case "img":
                                if ($img == undefined) {
                                    e(".layer-" + t + "-editor").html("New Image")
                                } else {
                                    e(".layer-" + t + "-editor").html('<img class="' + $css + '" src="' + $img + '" />')
                                }
                                break;
                            case "div":
                                e(".layer-" + t + "-editor").html($div.val());
                                break;
                            default:
                                e(".layer-" + t + "-editor").html("New Layer");
                                break;
                            }
                        });
                        e(".layer-" + t + "-editor").draggable({
                            cursor: "crosshair",
                            containment: "parent",
                            stop: function (n, r) {
                                var i = $slideWrap.offset();
                                $pos = r.helper.offset();
                                e(".layer-x-" + t + "-draggable").val(($pos.left - i.left).toFixed(0));
                                e(".layer-y-" + t + "-draggable").val(($pos.top - i.top).toFixed(0))
                            }
                        });
                        e("input.layer-x-" + t + "-draggable").keyup(function () {
                            e(".layer-" + t + "-editor").css("left", e(this).val() + "px")
                        });
                        e("input.layer-y-" + t + "-draggable").keyup(function () {
                            e(".layer-" + t + "-editor").css("top", e(this).val() + "px")
                        });
                        $cssField.keyup(function (n) {
                            $value = 'tp-caption '+e(this).val();
                            n = $value;
                            switch (e(".select-" + t + "-menu").val()) {
                            case "img":
                                e(".layer-" + t + "-editor").removeClass().addClass('layer layer-' + t + '-editor '+$value);
                                break;
                            case "div":
                                e(".layer-" + t + "-editor ").removeClass().addClass('layer layer-' + t + '-editor '+$value);
                                break;
                            }
                            e(".layer-" + t + "-editor").draggable({
                                cursor: "crosshair",
                                containment: "parent",
                                stop: function (n, r) {
                                    var i = $slideWrap.offset();
                                    $pos = r.helper.offset();
                                    e(".layer-x-" + t + "-draggable").val(($pos.left - i.left).toFixed(0));
                                    e(".layer-y-" + t + "-draggable").val(($pos.top - i.top).toFixed(0))
                                }
                            });
                        });
                        
                        $div.keyup(function () {
                            e(".layer-" + t + "-editor").html(e(this).val())
                        })
                    });
                    $newLayer = e("div.preview-bg .layer-" + $index + "-editor").exists();
                    if ($newLayer == false) {
                       e('.peCaption').append('<div class="layer layer-' + $index + '-editor">New Layer</div>')
                    }
                    e(".preview-bg  div.layer").each(function () {
                        e(".layer-" + $index + "-editor").draggable({
                            cursor: "crosshair",
                            containment: "parent",
                            stop: function (t, n) {
                                var r = $slideWrap.offset();
                                $pos = n.helper.offset();
                                e(".layer-x-" + $index + "-draggable").val(($pos.left - r.left).toFixed(0));
                                e(".layer-y-" + $index + "-draggable").val(($pos.top - r.top).toFixed(0))
                            }
                        })
                    })
                });
                $preview_img = e(".field-name-field-image .image-widget span.file").find("a").attr("href");
                e(".field-name-field-image .image-widget input[type='submit']").once(function () {
                    var t = new Image;
                    t.onload = function () {
                        e(".slide-builder").width(e(".slide-builder").parent().width());
                        e("div.preview-bg").css("width", $width).css("height", $height);
                        e("div.preview-wrap").css("background-image", "url(" + $preview_img + ")").css("width", '100%').css("height", $maxHeight).css("background-position", "center").css('paddingTop', $margin).css('marginBottom', -$margin);
                        e("div.peCaption").css("width", $width).css("height", $height);
                    };
                    t.src = $preview_img;
                    if ($preview_img == undefined) {
                        e("div.preview-wrap").css("background-image", "none")
                    } else {
                        e("div.preview-wrap").css("background-image", "url(" + $preview_img + ")")
                    }
                });
                $subLayer.each(function () {
                    $i = e(this).index();
                    $img = e(this).find(".form-managed-file span.file").find("a").attr("href");
                    $selected = e(this).find("select.edit-pe_slider-fields-layer-"+$i);
                    e(".edit-pe_slider-fields-image-" + $i + " > input[type='submit'], .edit-pe_slider-fields-image-" + $i + " > input[type='submit']").once(function () {
                        if ($img == undefined && $selected.val() == "img") {
                            e(".layer-" + $i + "-editor").html("New Image")
                        } else if ($img !== undefined && $selected.val() == "img") {
                            e(".layer-" + $i + "-editor").html('<img src="' + $img + '" />')
                        }
                    })
                })
            }
        }
    }
    
})