// 地区选择
// 获取省
function getProvince(ele, id) {
	api('System.Address.province', {}, function (res) {
		var data = res.data;
		var html = '<option value="0">请选择省</option>';
		if (data.length > 0) {
			for (i = 0; i < data.length; i++) {
				var item = data[i];
				if (id != undefined && id == item.province_id) {
					html += '<option value="' + item.province_id + '" selected>' + item.province_name + '</option>';
				} else {
					html += '<option value="' + item.province_id + '">' + item.province_name + '</option>';
				}
			}
		}
		$(ele).html(html);
	})
}

// 获取市	
function getCity(ele, pid, id) {
	api('System.Address.city', {"province_id": pid}, function (res) {
		var data = res.data;
		var html = '<option value="0">请选择市</option>';
		if (data.length > 0) {
			for (i = 0; i < data.length; i++) {
				var item = data[i];
				if (id != undefined && id == item.city_id) {
					html += '<option value="' + item.city_id + '" selected>' + item.city_name + '</option>';
				} else {
					html += '<option value="' + item.city_id + '">' + item.city_name + '</option>';
				}
			}
		}
		$(ele).html(html);
	})
}

// 获取区县
function getDistrict(ele, pid, id) {
	api('System.Address.district', {"city_id": pid}, function (res) {
		var data = res.data;
		var html = '<option value="0">请选择区/县</option>';
		if (data.length > 0) {
			for (i = 0; i < data.length; i++) {
				var item = data[i];
				if (id != undefined && id == item.district_id) {
					html += '<option value="' + item.district_id + '" selected>' + item.district_name + '</option>';
				} else {
					html += '<option value="' + item.district_id + '">' + item.district_name + '</option>';
				}
			}
		}
		$(ele).html(html);
	})
}