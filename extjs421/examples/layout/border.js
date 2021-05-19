Ext.require(['*']);

Ext.onReady(function() {
    var cw;

    Ext.state.Manager.setProvider(Ext.create('Ext.state.CookieProvider'));

    function closeRegion (e, target, header, tool) {
        var panel = header.ownerCt;
        newRegions.unshift(panel.initialConfig);
        viewport.remove(panel);
    }



    var viewport = Ext.create('Ext.Viewport', {
        layout: {
            type: 'border',
            padding: 5
        },
        defaults: {
            split: true
        },
        items: [{
            region: 'north',
            collapsible: true,
            title: 'North',
            split: true,
            height: 100,
            minHeight: 60,
            html: 'north'
        },{
            region: 'center',
            html: 'center center',
            title: 'Center',
            minHeight: 80,
            items: [cw = Ext.create('Ext.Window', {
                xtype: 'window',
                closable: false,
                minimizable: true,
                title: 'Constrained Window',
                height: 200,
                width: 400,
                constrain: true,
                html: 'I am in a Container',
                itemId: 'center-window',
                minimize: function() {
                    this.floatParent.down('button#toggleCw').toggle();
                }
            })],
            bbar: [ 'Text followed by a spacer', ' ', {
                itemId: 'toggleCw',
                text: 'Constrained Window',
                enableToggle: true,
                toggleHandler: function() {
                    cw.setVisible(!cw.isVisible());
                }
            }, {
                text: 'Add Region',
                listeners: {
                    click: function () {
                        if (newRegions.length) {
                            var region = newRegions.pop();
                            region.tools = [ { type: 'close', handler: closeRegion }];
                            viewport.add(region);
                        } else {
                            Ext.Msg.show({
                                title: 'All added',
                                msg: 'Close one of the dynamic regions first',
                                //minWidth: Ext.Msg.minWidth,
                                buttons: Ext.Msg.OK,
                                icon: Ext.Msg.ERROR
                            });
                        }
                    }
                }
            }, {
                text: 'Change Titles',
                listeners: {
                    click: function () {
                        var panels = viewport.query('panel');
                        Ext.suspendLayouts();
                        Ext.Array.forEach(panels, function (panel) {
                            panel.setTitle(panel.title + '!');
                        });
                        Ext.resumeLayouts(true);
                    }
                }
            }]
        },{
            region: 'east',
            collapsible: true,
            floatable: true,
            split: true,
            width: 200,
            minWidth: 120,
            minHeight: 140,
            title: 'East',
            layout: {
                type: 'vbox',
                padding: 5,
                align: 'stretch'
            },
            items: [{
                xtype: 'textfield',
                labelWidth: 70,
                fieldLabel: 'Text field'
            }, {
                xtype: 'component',
                html: 'I am floatable'
            }]
        },{
            region: 'south',
            height: 100,
            split: true,
            collapsible: true,
            title: 'Splitter above me',
            minHeight: 60,
            html: 'center south',
            weight: -100
        },{
            region: 'south',
            collapsible: true,
            split: true,
            height: 200,
            minHeight: 120,
            title: 'South',
            layout: {
                type: 'border',
                padding: 5
            },
            items: [{
                title: 'South Central',
                region: 'center',
                minWidth: 80,
                html: 'South Central'
            }, {
                title: 'South Eastern',
                region: 'east',
                flex: 1,
                minWidth: 80,
                html: 'South Eastern',
                split: true,
                collapsible: true
            }, {
                title: 'South Western - not resizable',
                region: 'west',
                flex: 1,
                minWidth: 80,
                html: 'South Western<br>I collapse to nothing',
                split: true,
                collapsible: true,
                splitterResize: false,
                collapseMode: 'mini'
            }]
        }]
    });
});

Ext.define('Ext.example.RegionSetter', {
    extend: 'Ext.Component',
    xtype: 'regionsetter',
    style: 'font-size: 30px;',
    autoEl: {
        tag: 'table',
        cn: [{
            tag: 'tr',
            cn: [{
                tag: 'td',
                colspan: 3,
                align: 'center',
                cls: 'ux-arrow ux-arrow-up',
                //html: '&#9757;'
                html: '&#9650;'
            }]
        },{
            tag: 'tr',
            cn: [{
                tag: 'td',
                cls: 'ux-arrow ux-arrow-left',
                //html: '&#9756;'
                html: '&#9668;'
            },{
                tag: 'td',
                style: 'font-size: 120%',
                html: '&#9728;'
            },{
                tag: 'td',
                cls: 'ux-arrow ux-arrow-right',
                //html: '&#9758;'
                html: '&#9658;'
            }]
        },{
            tag: 'tr',
            cn: [{
                tag: 'td',
                colspan: 3,
                align: 'center',
                cls: 'ux-arrow ux-arrow-down',
                //html: '&#9759;'
                html: '&#9660;'
            }]
        }]
    },

    afterRender: function () {
        this.callParent();
        
        this.ownerCt.on({
            changeregion: 'onChangeRegion',
            scope: this
        });
        this.onChangeRegion(this.ownerCt);

        this.el.on({
            click: this.onClick,
            mouseover: this.onMouseOver,
            mouseout: this.onMouseOut,
            scope: this
        });
    },

    onClick: function (e) {
        var target = Ext.fly(e.getTarget());
        var region;

        if (target.hasCls('ux-arrow-up')) {
            region = 'north';
        } else if (target.hasCls('ux-arrow-left')) {
            region = 'west';
        } else if (target.hasCls('ux-arrow-right')) {
            region = 'east';
        } else if (target.hasCls('ux-arrow-down')) {
            region = 'south';
        }

        if (region && region !== this.ownerCt.region) {
            this.ownerCt.setBorderRegion(region);
        }
    },

    onMouseOver: function (e) {
        var target = Ext.fly(e.getTarget());
        if (target.hasCls('ux-arrow')) {
            target.addCls('ux-arrow-over');
        }
    },

    onMouseOut: function (e) {
        var target = Ext.fly(e.getTarget());
        target.removeCls('ux-arrow-over');
    },

    onChangeRegion: function (panel, oldRegion) {
        if (oldRegion) {
            this.removeCls('ux-arrow-current-' + oldRegion);
        }
        this.addCls('ux-arrow-current-' + panel.region);

    }
});
