dhtmlXRibbon.prototype.setItemImage = function(id, img) {
	var item = this._items[id];
	if (item != null && this.items[item.type] != null && typeof(this.items[item.type].setImage) == "function") {
		this.items[item.type].setImage(item, img);
	}
};
dhtmlXRibbon.prototype.setItemImageDis = function(id, imgdis) {
	var item = this._items[id];
	if (item != null && this.items[item.type] != null && typeof(this.items[item.type].setImageDis) == "function") {
		this.items[item.type].setImageDis(item, imgdis);
	}
};
dhtmlXRibbon.prototype.items.button.setImage = function(item, img) {
	item.conf.img = img;
	if (item.conf.disable == false) {
		item.base.childNodes[0].src = item.conf.icons_path+item.conf.img;
	}
};
dhtmlXRibbon.prototype.items.button.setImageDis = function(item, imgdis) {
	item.conf.imgdis = imgdis;
	if (item.conf.disable == true) {
		item.base.childNodes[0].src = item.conf.icons_path+item.conf.imgdis;
	}
};
