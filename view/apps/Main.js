Ext.define("App.Main",{
	extend:"Ext.util.Observable",
	constructor:function(){
		this.callParent();
		this.init();
	},
	init:function(){
		App.Store=Ext.create("App.Store");
		Ext.tip.QuickTipManager.init();
		Ext.Function.defer(function(){
			this.createViewport();
		},1000,this);
	},
	home:function(){
		App.Main.contentPanel.getLayout().setActiveItem("home");
	},
	setContent:function(appName){
		var me=this;
		me.viewport.setLoading(true,true);
		if(!Ext.ClassManager.isCreated(appName)){
			ap = Ext.create(appName,{
				mainId:appName
			});
			if (!Ext.isEmpty(ap.Main) && ap.autoSet)
				me.contentPanel.add(ap.Main);
		}
		try{
			me.contentPanel.getLayout().setActiveItem(appName);
		}catch(r){App.Utils.handleError();}
		me.viewport.setLoading(false);
	},
	showWindow:function(appName){
		var app,
			me=this;
		app=appName.split(".");
		if (Ext.isEmpty(App.window))App.window={};
		if(!Ext.ClassManager.isCreated(appName)){
			App.window[app[2]] = Ext.create(appName,{
				mainContent:me.contentPanel
			});
		}
		App.window[app[2]].show();
	},
	doLogin : function(){
		this.contentMenu.getComponent(1).getForm().submit({
			scope : this,
			success : this.onSuccess,
			failure : this.onFailure,
		});
	},
	logout : function(){
		this.winLogout =Ext.Msg.show({
			title:'Anda Yakin ?',
			msg: 'Akan keluar dan menutup sesi ini ?',
			buttons: Ext.Msg.OKCANCEL,
			scope : this,
			fn: this.doLogout,
			icon: Ext.window.MessageBox.QUESTION
		});
	},
	doLogout : function(a){
		if (a == "ok"){
			Ext.Ajax.request({
				url : "controller/login/dologout",
				scope : this,
				success : function(a,b){
					App.Utils.showLoading("Closing session");
					Ext.Function.defer(function(){
						window.location.reload(true);
					},2000,this);
				}
			});
		}else{
			this.winLogout.hide();
		}
	},
	onSuccess : function(a,b){
		if (b.result.login){
			App.Utils.showLoading("Sedang Masuk");
			Ext.Function.defer(function(){
				window.location.reload(true);
			},2000,this);
		}
		else this.onFailure(null,b);
	},
	onFailure : function(a,b){
		if (b.result){
			Ext.each(b.result.errorMsg, function(c){
				this.contentMenu.getComponent(1).getComponent(c.inp).markInvalid(c.reason);
			},this);
		}
	},
	createViewport:function(){
		if(App.isLogin){
			var obj=[{
				id:"action-logout",
				iconCls:"icon-logout",
				text:"Logout",
				scope:this,
				handler:function(){
					App.Main.logout();
				}
			}];
		}else{
			var obj=[{
				fieldLabel: 'Username',
				name: 'username',
				itemId : "username"
			},{
				fieldLabel: 'Password',
				name: 'password',
				inputType : "password",
				itemId : "password"
			},{
				xtype:"button",
				text:"Masuk",
				handler:this.doLogin,
				scope:this
			}];
		}
		this.contentMenu = Ext.create("Ext.Panel",{
			id:'content-Menu',
			region:'west',
			width:220,
			split:true,
			layout:"anchor",
			bodyStyle:{
				background:'#DFE8F6',
				padding:'5px'
			},
			defaults:{
				anchor:'-1px',
				xtype:"contentmenu",
				style:"margin-bottom:5px",
				frame:true,
				width:true,
				collapsed:true,
				autoWidth:false,
				autoHeight:true,
				collapsible:true,
				titleCollapse:true
			},
			items:[{
				title:"Data Master",
				collapsed:false,
				items:[{
					id:"action-bahan",
					iconCls:"icon-monitor",
					text:"DUK",
					handler:function(){
						App.Main.setContent("App.grid.Duk");
					}
				}]
			},{
				title:"Akun",
				xtype:(App.isLogin)?"contentmenu":"form",
				url : "controller/login/dologin",
				layout: 'anchor',
				defaults:{
					anchor:'100%',
					labelWidth : 70,
					labelSeparator : "",
					msgTarget : "side",
					allowBlank: false,
					xtype:"textfield"
				},
				collapsed:false,
				autoHeight:true,
				collapsible:false,
				items:obj
			}]
		});

		this.contentPanel = new Ext.Panel( {
			id:'content-panel',
			region:'center',
			layout:'card',
			activeItem:0,
			split:true,
			border:false,
			frame:false,
			items:[{
				title:"Beranda",
				autoScroll:true,
				itemId:"home",
				loader:{
					url:'controller/home/show',
					autoLoad:true
				}
			}]
		});

		this.viewport = Ext.create('Ext.container.Viewport', {
			layout:'border',
			items:[{
				region:'north',
				height:60,
				border:false,
				padding:8,
				bodyStyle:"background-color:#DFE8F6",
				contentEl:"header"
			},this.contentMenu,this.contentPanel]
		});
		App.Utils.removeLoading();
	}
});
