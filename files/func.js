window.onerror = null;
$(function() {

				window.history.replaceState(null, null, window.location.pathname);
                $('#MinRange').html(Math.floor(($('#BetPercent').val() / 100) * 999999));
                $('#MaxRange').html(999999 - Math.floor(($('#BetPercent').val() / 100) * 999999));
                $('#BetProfit').html(((100 / $('#BetPercent').val()) * $('#BetSize').val()).toFixed(2));
            });
									function historys() {
if(navigator.onLine) {
 $.ajax({
            url: '/inc/core.php',
            timeout: 10000,
            success: function(data) {
							var obj = jQuery.parseJSON(data);
							var count = 0;
							if(obj.count == 0)
							{
								count;
							}
							if(obj.count >= 15) {
								count = 15;
							}
							if(obj.count < 15) {
								count = obj.count;
							}
							$("#response").prepend(obj.game);
							$('#response').children().slice(count).remove();
							$("#oe").html(obj.online);
            },
            error: function() {
            }
        });
		} else {
}
		}

		setInterval('historys()',300);


										function offliner() {
if(navigator.onLine) {
 $.ajax({
            url: '/inc/offline.php',
            timeout: 10000,
            success: function(data) {
            },
            error: function() {
            }
        });
		} else {
}
		}

		setInterval('offliner()',3000);

		$('#site_info, #site_contacts').redactor();

		function new_reset_pass() {
			if ($('#pass').val().length < 5) {
          $('#error_reset').css('display', 'block');
          return $('#error_reset').html('Пароль от 5 символов');
      }
      if ($('#pass').val() != $('#repeatPass').val()) {
          $('#error_reset').css('display', 'block');
          return $('#error_reset').html('Пароли не совпадают');
      }

      $.ajax({
          type: 'POST',
          url: '/inc/engine.php',
          beforeSend: function() {
              $('#error_reset').css('display', 'none');
          },
          data: {
              type: "newResetPass",
              pass: $('#pass').val(),
							hash: $('#hash').val(),
							sid: $('#uid').val()
          },
					success: function(data) {
              var obj = jQuery.parseJSON(data);
              if (obj.success == "success") {
                 $("#succes_resetPass").show();
								 setTimeout(function() {
                   window.location.href = '/';
                 }, 5000);
						 		 return false;
              }else{
								$('#error_resetPass').show();
								return $('#error_resetPass').html(obj.error);
							}
          }
      });
	  };

		function hideBonus(){
			$.ajax({
				type: 'POST',
				url: '/inc/engine.php',
				data: {
					type: "hideBonus",
					sid: Cookies.get('sid')
			},
			success: function(data) {
					var obj = jQuery.parseJSON(data);
					if (obj.success == "success") {
						$('#bonusRow').hide();
					}
				}
			});
		};

		function getBonus() {
			if ($('#vkPage').val() == ''){
				$('#error_bonus').show();
				return $('#error_bonus').html('Введите страницу');
			}

			$.ajax({
				type: 'POST',
				url: '/inc/engine.php',
				data: {
					type: 'getBonus',
					sid: Cookies.get('sid'),
					vk: $('#vkPage').val(),
					a:  Cookies.get('ab')
			},
			success: function(data) {
					var obj = jQuery.parseJSON(data);
					if (obj.success == "success")
					{
						Cookies.set('ab', '1');
						$('#success_bonus').show();
						$('#success_bonus').html(obj.error);
						$('#userBalance').attr('myBalance', obj.new_balance);
						updateBalance(obj.balance, obj.new_balance);
						$('#error_bonus').hide();
						setTimeout(function() {
							$('#bonusRow').hide();
						}, 2500);

					}
					if (obj.success == "error") {
						setTimeout(function() {
							$('#bonusRow').hide();
						}, 2500);
						$('#error_bonus').show();
						return $('#error_bonus').html(obj.error);
					}
				}
			});
		};

		function vkunconnect() {
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
							type: "vkunconnect",
							sid: Cookies.get('sid'),
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == "success") {
							$('#vk_success').show();
							$('#vk_success').html(obj.error);
							setTimeout(function(){
								$('#vk_success').hide();
							},7000);
							$('#vkupd').html('<a style="color:#3B5998" href="https://oauth.vk.com/authorize?client_id='+client_id+'&display=page&redirect_uri='+url+'&response_type=code&v=5.74" class="btn btn-social mb-1 mr-1 btn-outline-facebook"><span class="fa fa-vk"></span> <span class="px-1">Привязать ВК</span> </a>');
						}else {
							$('#vk_error').show();
							$('#vk_error').html(obj.error);
							setTimeout(function(){
								$('#vk_error').hide();
							},7000);
						}
					}
			});
		};

		function settings_site() {
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'settings_site',
						sid: Cookies.get('sid'),
						s_name: $('#site_name').val(),
						s_domain: $('#site_domain').val(),
						s_url: $('#site_url').val(),
						s_footer: $('#site_footer').val(),
						s_bgc: $('#bgc_site').val(),
						s_imin: $('#input_f').val(),
						s_omin: $('#out_f').val(),
						s_imax: $('#inputmax_f').val(),
						s_omax: $('#outmax_f').val(),
						s_bonus: $('#bonus_reg').val(),
						s_wallet: $('#wallet_site').val(),
						id_vk: $('#vk_group_id').val(),
						token_vk: $('#vk_group_token').val(),
						s_info: $('#site_info').val(),
						phone: $('#qiwi_num').val(),
						token: $('#qiwi_token').val(),
						vk_id: $('#vk_id').val(),
						vk_secret: $('#vk_secret').val(),
						prel_active: $('#active_preloader').val(),
						qiwi_active: $('#active_qiwi').val(),
						fk_active: $('#active_fk').val(),
						payeer_active: $('#active_payeer').val(),
						s_contacts: $('#site_contacts').val(),
						minBetPercent: $('#minBetPercent').val(),
						maxBetPercent: $('#maxBetPercent').val(),
						betSizeMin: $('#betSizeMin').val()
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#main_success').show().html('Настройки сайта изменены');
							setTimeout(function() {
								$('#main_success').hide();
							},5000);
							$('body').css('background-image', 'url(img/'+obj.bgc+')');
							$('#s_name').html(obj.name);
							$('#s_footer').html(obj.footer);
							$('#s_info').html(obj.info);
							wallet = obj.wallet;
							minbetsize = obj.minbetsize;
						}
					}
			});
		};

		function del_user(event) {
			var id = $(event.target)[0].id;
			if(confirm("Удалить аккаунт?")){
				$.ajax({
						type: 'POST',
						url: '/inc/engine.php',
						data: {
							type: 'del_user',
							sid: Cookies.get('sid'),
							id: id
						},
						success: function(data) {
							var obj = jQuery.parseJSON(data);
							if (obj.success == 'success') {
								upd_adm();
								$('#adm-users').show();
								$('#infouser').hide();
								$('#vk_success').show().html(obj.error);
								setTimeout(function() {
									$('#vk_success').hide();
								},5000);
							}else {
								$('#vk_error').show().html(obj.error);
								setTimeout(function() {
									$('#vk_error').hide();
								},5000);
							}
						}
				});
				return true;
			}else return false;
		};

		function obnul_pod() {
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'obnul_site',
						sid: Cookies.get('sid')
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#pod_success').show().html('Подкрутка сайта обнулена');
							setTimeout(function() {
								$('#pod_success').hide();
							},5000);
						}
					}
			});
		};

		function perevod_wallet() {

			if($('#nick_user').val() == ''){
				return $('#error_perevod').show().html('Заполните все поля');
			}

			if($('#suma_perevoda').val() == ''){
				return $('#error_perevod').show().html('Заполните все поля');
			}

			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'perevod_wallet',
						sid: Cookies.get('sid'),
						nick: $('#nick_user').val(),
						summa: $('#suma_perevoda').val()
					},
					beforeSend: function() {
							$('#loader3').css('position', '').show();
							$('#dot-container3').show();
							$('#perevod_btn').hide();
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#success_perevod').show().html(obj.error);
							$('#error_perevod').hide();
							$('#nick_user').val('');
							$('#suma_perevoda').val('');
							updateBalance(obj.balance, obj.new_balance);
							setTimeout(function () {
								$('#success_perevod').hide();
							},5000);
							$('#loader3').show();
							$('#dot-container3').hide();
							$('#perevod_btn').show();
						}else{
							$('#loader3').show();
							$('#dot-container3').hide();
							$('#perevod_btn').show();
							$('#error_perevod').show().html(obj.error);
						}
					}
			});
		};

		function check_qiwi() {
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'check_qiwi',
						sid: Cookies.get('sid')
					},
					beforeSend: function() {
							$('#loader1').css('position', '').show();
							$('#dot-container1').show();
							$('#withdrawB-ch').hide();
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#qiwi_bal').html(obj.bqiwi);
							$('#loader1').css('position', '').hide();
							$('#dot-container1').hide();
							$('#withdrawB-ch').show();
						}else{
							$('#out_error').show().html(obj.error);
							setTimeout(function () {
								$('#out_error').hide();
							}, 5000);
							$('#loader1').css('position', '').hide();
							$('#dot-container1').hide();
							$('#withdrawB-ch').show();
						}
					}
			});
		};

		function perevod_qiwi() {

			if($('#num_perevod').val() == '')
			{
				return $('#out_error').show().html('Заполните все поля');
			}

			if($('#num_perevod').val().length < 11)
			{
				return $('#out_error').show().html('Номер телефона меньше 11 символов');
			}

			if($('#summ_perevod').val() == '')
			{
				return $('#out_error').show().html('Заполните все поля');
			}

			if($('#comment_perevod').val() == '')
			{
				return $('#out_error').show().html('Заполните все поля');
			}

			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'perevod_qiwi',
						sid: Cookies.get('sid'),
						vtel: $('#num_perevod').val(),
						vamount: $('#summ_perevod').val(),
						vcomment: $('#comment_perevod').val()
					},
					beforeSend: function() {
							$('#loader2').css('position', '').show();
							$('#dot-container2').show();
							$('#withdrawB-perevod').hide();
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#out_success').show().html(obj.error);
							setTimeout(function () {
								$('#out_success').hide();
							}, 5000);
							$('#out_error').hide();
							$('#num_perevod').val('');
							$('#summ_perevod').val('');
							$('#loader2').css('position', '').hide();
							$('#dot-container2').hide();
							$('#withdrawB-perevod').show();
						}else {
							$('#out_error').show().html(obj.error);
							$('#loader2').css('position', '').hide();
							$('#dot-container2').hide();
							$('#withdrawB-perevod').show();
						}
					}
			});
		};

		function adm_out() {
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'adm_out',
						sid: Cookies.get('sid'),
						currency: $('#out-currency').val(),
						amount: $('#out-amount').val(),
					},
					beforeSend: function() {
							$('#loader').css('position', '').show();
							$('#dot-container').show();
							$('#withdrawB-out').hide();
					},
					success: function(data) {
						if (data == 'Минимальный вывод 50 '+wallet+'null') {
							$('#out_error').show();
							$('#out_error').html(data);
							setTimeout(function() {
								$('#out_error').hide();
							},5000);
							$('#loader').css('position', '').hide();
							$('#dot-container').hide();
							$('#withdrawB-out').show();
						}else {
							$('#out_success').show();
							$('#out_success').html(data);
							setTimeout(function() {
								$('#out_success').hide();
							},5000);
							$('#loader').css('position', '').hide();
							$('#dot-container').hide();
							$('#withdrawB-out').show();
						}
					}
			});
		};

		function save_oplata() {
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'oplata',
						sid: Cookies.get('sid'),
						fkid: $('#fk_id').val(),
						fksecret: $('#fk_secret').val(),
						fksecret2: $('#fk_secret2').val(),
						prid: $('#pr_id').val(),
						prkey: $('#pr_key').val(),
						prcurr: $('#pr_curr').val()
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#opl_success').show();
							$('#opl_success').html(obj.error);
							setTimeout(function() {
								$('#opl_success').hide();
							},5000);
							$('#fk_id').val(obj.fkid);
							$('#fk_secret').val(obj.fksc);
							$('#fk_secret2').val(obj.fksc2);
							$('#pr_id').val(obj.prid);
							$('#pr_key').val(obj.prkey);
							$('#pr_curr').val(obj.prcurr);
						}
					}
			});
		};

		function save_pd() {
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'pod',
						sid: Cookies.get('sid'),
						ws: $('#win_user').val(),
						ls: $('#lose_user').val(),
						wy: $('#win_yt').val(),
						ly: $('#lose_yt').val(),
						pu: $('#pd_user').val(),
						ps: $('#pd_site').val()
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#pod_success').show();
							$('#pod_success').html(obj.error);
							setTimeout(function() {
								$('#pod_success').hide();
							},5000);
							$('#win_user').val(obj.wu);
							$('#lose_user').val(obj.lu);
							$('#win_yt').val(obj.wy);
							$('#lose_yt').val(obj.ly);
							$('#pd_user').val(obj.pu);
							$('#pd_site').val(obj.ps);
							$('#puinfo').html('Режим подкрутки '+'('+obj.pu+')');
							$('#psinfo').html('Подкрутка сайта '+'('+obj.ps+')');
						}
					}
			});
		};

		function last_out() {
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'outusers',
						page: $('#pgi_l').val()
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#tableoutusers').html(obj.out);
							$('#pg_l').html(obj.pg);
						}
					}
			});
		};

		function my_referal() {
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'referals',
						sid: Cookies.get('sid')
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#thref').html(obj.thref);
							$('#tableref').html(obj.tbref);
							$('#myrefurl').html(obj.refurl);
							$('#myrefurlcopy').attr('data-clipboard-text', obj.refurl);
							$('#vk_error').hide();
						}
					}
			});
		};

		function new_stat(event) {
			var id = $(event.target)[0].id;
			var val = $(event.target)[0].value;
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'new_stats',
						sid: Cookies.get('sid'),
						id: id,
						value: val
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							upd_adm();
						}
					}
			});
		};

		function search_user() {

			if($('#search_u').val() == '')
			{
				return upd_adm();
			}

			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'search_users',
						sid: Cookies.get('sid'),
						nick: $('#search_u').val()
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#tableusers').html(obj.users);
						}
					}
			});
		};

		function del_promo(event) {
			var id = $(event.target)[0].id;
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'adm_promo',
						sid: Cookies.get('sid'),
						page: $('#pgi_promo').val(),
						id: id
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#tablepromo').html(obj.promo);
							$('#vk_error').hide();
							$('#pg_promo').html(obj.pg);
						}else {
							$('#tablepromo').html(obj.promo);
							$('#vk_error').show().html(obj.error);
						}
					}
			});
		};

		function show_active(event) {
			var id = $(event.target)[0].id;
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'adm_promo',
						sid: Cookies.get('sid'),
						page: $('#pgi_promo').val(),
						idshow: id
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#show_active').show();
							$('#adm-promo').hide();
							$('#sh_ac_promo').html(obj.sh_promo);
							$('#sh_ac_id').html(obj.sh_id);
						}
					}
			});
		};

		function create_promo() {

			if($('#name_promo').val() == ''){
				return $('#promo_error').show().html('Заполните поле Промокод');
			}
			if($('#max_promo').val() == ''){
				return $('#promo_error').show().html('Заполните поле Макс активаций');
			}
			if($('#sum_promo').val() == ''){
				return $('#promo_error').show().html('Заполните поле Сумма за активацию');
			}

			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'new_promo',
						sid: Cookies.get('sid'),
						name: $('#name_promo').val(),
						max: $('#max_promo').val(),
						summ: $('#sum_promo').val()
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#promo_success').show().html(obj.error);
							setTimeout(function() {
								$('#promo_success').hide();
							}, 5000);
							$('#name_promo').val('');
							$('#max_promo').val('');
							$('#sum_promo').val('');
							$('#promo_error').hide();
						}
					}
			});
		};

		function upd_adm() {
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'adm_users',
						sid: Cookies.get('sid'),
						page: $('#pgi_u').val()
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#tableusers').html(obj.users);
							$('#vk_error').hide();
							$('#pg_u').html(obj.pg);
						}else {
							$('#tableusers').html(obj.users);
							$('#vk_error').show().html(obj.error);
						}
					}
			});
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'lastout',
						sid: Cookies.get('sid'),
						page: $('#pgi_o').val()
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#tableout').html(obj.out);
							$('#vk_error').hide();
							$('#pg_o').html(obj.pg);
						}else {
							$('#tableout').html(obj.out);
							$('#vk_error').show().html(obj.error);
						}
					}
			});
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'adm_pays',
						sid: Cookies.get('sid'),
						page: $('#pgi_p').val()
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#tablepays').html(obj.pays);
							$('#vk_error').hide();
							$('#pg_p').html(obj.pg);
						}else {
							$('#tablepays').html(obj.pays);
							$('#vk_error').show().html(obj.error);
						}
					}
			});
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'adm_promo',
						sid: Cookies.get('sid'),
						page: $('#pgi_promo').val()
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#tablepromo').html(obj.promo);
							$('#vk_error').hide();
							$('#pg_promo').html(obj.pg);
						}else {
							$('#tablepromo').html(obj.promo);
							$('#vk_error').show().html(obj.error);
						}
					}
			});
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'adm_stats',
						sid: Cookies.get('sid')
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#user_games_adm').html(obj.games);
							$('#user_fcount_adm').html(obj.fcount);
							$('#user_f_adm').html(obj.f);
							$('#user_pay_adm').html(obj.pay);
							$('#user_out_adm').html(obj.out);
							$('#vk_error').hide();
						}else {
							$('#user_games_adm').html(obj.games);
							$('#user_fcount_adm').html(obj.fcount);
							$('#user_f_adm').html(obj.f);
							$('#user_pay_adm').html(obj.pay);
							$('#user_out_adm').html(obj.out);
							$('#vk_error').show().html(obj.error);
						}
					}
			});
		}

		function save_edit(event) {
			var id = $(event.target)[0].id;
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'save_edit',
						iduser: id,
						sid: Cookies.get('sid'),
						login: $('#edit_login_user').val(),
						pass: $('#edit_pass_user').val(),
						email: $('#edit_email_user').val(),
						balance: $('#edit_balance_user').val(),
						ban: $('#edit_ban_user').val(),
						banmess: $('#edit_banmess_user').val(),
						pod: $('#edit_pod_user').val(),
						admin: $('#edit_admin_user').val()
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#vk_success').show();
							$('#vk_success').html(obj.error);
							setTimeout(function() {
								$('#vk_success').hide();
							},5000);
						} else {
							$('#vk_error').show();
							$('#vk_error').html(obj.error);
							setTimeout(function() {
								$('#vk_error').hide();
							},5000);
						}
					}
			});
		};

		function info_edit(event) {
			var id = $(event.target)[0].id;
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'infouser',
						iduser: id,
						sid: Cookies.get('sid')
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('.dsec').hide();
							$('#info_edit_user').show();
							$('#info_edit_login').html('Изменить данные '+ '<b>'+obj.login+'</b>');
							$('#login_user_edit').html('Логин: '+ '<input id="edit_login_user" class="form-control" type="text" value="'+obj.login+'"/>');
							$('#pass_user_edit').html('Пароль: '+ '<input id="edit_pass_user" class="form-control" type="text" value="'+obj.pass+'"/>');
							$('#balance_user_edit').html('Баланс ('+wallet+'): '+ '<input id="edit_balance_user" class="form-control" type="text" value="'+obj.balance+'"/>');
							$('#email_user_edit').html('Email: '+ '<input id="edit_email_user" class="form-control" type="email" value="'+obj.email+'"/>');
							$('#ban_user_edit').html('Блокировка: '+ '<select id="edit_ban_user" class="form-control"><option value="'+obj.ban+'">Изменить</option><option value="1">Заблокировать</option><option value="0">Разблокировать</option></select>');
							$('#banmess_user_edit').html('Нарушение пункта(Вкл): '+ '<select id="edit_banmess_user" class="form-control"><option value="">Выберите пункт</option><option value="1.1">1.1</option><option value="1.2">1.2</option><option value="1.3">1.3</option><option value="1.4">1.4</option><option value="2.1">2.1</option><option value="2.3">2.3</option><option value="2.4">2.4</option><option value="2.5">2.5</option><option value="2.6">2.6</option><option value="3.1">3.1</option><option value="3.2">3.2</option><option value="3.3">3.3</option><option value="4.1">4.1</option><option value="4.2">4.2</option><option value="4.3">4.3</option><option value="5.1">5.1</option><option value="5.2">5.2</option><option value="5.3">5.3</option><option value="5.4">5.4</option><option value="5.5">5.5</option><option value="5.6">5.6</option><option value="5.7">5.7</option><option value="5.8">5.8</option><option value="6.1">6.1</option><option value="6.2">6.2</option><option value="6.3">6.3</option><option value="6.4">6.4</option><option value="6.5">6.5</option><option value="6.6">6.6</option><option value="6.7">6.7</option><option value="6.8">6.8</option><option value="7.1">7.1</option><option value="7.2">7.2</option></select>');
							$('#pod_user_edit').html('Подкрутка: '+ '<select id="edit_pod_user" class="form-control"><option value="'+obj.podkrytka+'">Изменить</option><option value="1">Ютубер</option><option value="2">Юзер</option><option value="0">Выключить</option></select>');
							$('#admin_user_edit').html('Права: '+ '<select id="edit_admin_user" class="form-control"><option value="'+obj.admin+'">Изменить</option><option value="user">Пользователь</option><option value="sadmin">Администратор</option></select>');
						}
					}
			});
		};

		function profile(event) {
			var id = $(event.target)[0].id;
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'infouser',
						iduser: id,
						sid: Cookies.get('sid')
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							if(obj.ban == 1)
							{
								var ban = 'Заблокирован';
							}else {
								var ban = 'Не заблокирован';
							}
							if(obj.podkrytka == 1)
							{
								var pod = 'Включена';
							}else {
								var pod = 'Выключена';
							}
							if(obj.online == 1)
							{
								var online = 'В онлайне';
							}else {
								var online = 'В офлайне';
							}
							if(obj.admin == 'sadmin')
							{
								var admin = 'Администратор';
							}else {
								var admin = 'Пользователь';
							}
							if(obj.ref == '')
							{
								var ref = 'Нету реферала';
							}else {
								var ref = obj.ref;
							}
							if(obj.vkurl == 0)
							{
								var vkurl = 'Нету ссылки';
							}else {
								var vkurl = obj.vkurl;
							}
							if(obj.vkname == '')
							{
								var vkname = 'Вк не привязан';
							}else{
								var vkname = obj.vkname;
							}
							var login = obj.login;
							login = login[0].toUpperCase () + login.substr (1).toLowerCase ();
							$('.dsec').hide();
							$('#infouser').show();
							$('#btninfodel').html('<a id="'+obj.id+'" style="color:red;" onclick="del_user(event);">Удалить аккаунт</a>')
							$('#btninfo').html('<a id="'+obj.id+'" style="color:#00A5A8;" onclick="info_edit(event)">Изменить данные</a>');
							$('#btnEdit').html('<a id="'+obj.id+'" style="color:#00A5A8;" onclick="save_edit(event)">Сохранить данные</a>');
							$('#info_login').html('Информация о '+ '<b>'+obj.login+'</b>');
							$('#login_user').html('Логин: '+ '<b>'+login+'</b>');
							$('#pass_user').html('Пароль: '+ '<b>'+obj.pass+'</b>');
							$('#balance_user').html('Баланс: '+ '<b>'+obj.balance+'</b> '+wallet);
							$('#email_user').html('Email: '+ '<b>'+obj.email+'</b>');
							$('#refer_user').html('Пригласил: '+ '<b>'+ref+'</b>');
							$('#refer_pay_user').html('Доход с рефов: '+ '<b>'+obj.refpay+'</b> '+wallet);
							$('#ip_user').html('IP: '+ '<b>'+obj.ip+'</b>');
							$('#ip_reg_user').html('IP[Рег]: '+ '<b>'+obj.ipreg+'</b>');
							$('#ban_user').html('Блокировка: '+ '<b>'+ban+'</b>');
							$('#datareg_user').html('Дата рег: '+ '<b>'+obj.datareg+'</b>');
							$('#vkurl_user').html('Ссылка ВК: '+ '<b>'+vkurl+'</b>');
							$('#vkname_user').html('Имя ВК: '+ '<b>'+vkname+'</b>');
							$('#pod_user').html('Подкрутка: '+ '<b>'+pod+'</b>');
							$('#online_user').html('Сейчас: '+ '<b>'+online+'</b>');
							$('#admin_user').html('Права: '+ '<b>'+admin+'</b>');
						}
					}
			});
		};

		function developer() {
			$.ajax({
					type: 'POST',
					url: '/inc/engine.php',
					data: {
						type: 'dev'
					},
					success: function(data) {
						var obj = jQuery.parseJSON(data);
						if (obj.success == 'success') {
							$('#vk_success').show();
							$('#vk_success').html(obj.error);
							setTimeout(function() {
								$('#vk_success').hide();
							},5000);
						}
					}
			});
		};

		$('#menu-mob').click(function() {
		  if($('.nav-menu-main').hasClass('is-active')) {
		    $('#menu-mob').addClass('ft-menu');
				$('#menu-mob').removeClass('ft-x');
		  } else {
		    $('#menu-mob').addClass('ft-x');
				$('#menu-mob').removeClass('ft-menu');
		  }
		});

		new Clipboard('.btn-clipboard');

		$(window).on('load', function () {
			$preloader = $('.preloader'),
			$loader = $preloader.find('.page-loader-circle');
			$loader.fadeOut();
			$preloader.delay(350).fadeOut('slow');
		});

    jQuery (function ($) {
      $(function() {
        function select() {
          var select = $('#hide_search option:selected').val();
          switch (select) {
            case "Qiwi":
              $('#nameWithdraw').html('Номер телефона:');
              $('#walletNumber').attr('placeholder', '+');
              $('#walletNumber').val('+');
              break;
            case "YandexMoney":
              $('#nameWithdraw').html('Номер кошелька:');
              $('#walletNumber').attr('placeholder', '410011499718000');
							$('#walletNumber').val('4100');
              break;
            case "Payeer":
              $('#nameWithdraw').html('Номер кошелька:');
              $('#walletNumber').attr('placeholder', 'P1000000');
							$('#walletNumber').val('P');
              break;
            case "VISA":
              $('#nameWithdraw').html('Номер карты:');
              $('#walletNumber').attr('placeholder', '427607XXXX785577');
							$('#walletNumber').val('4276');
              break;
            case "MASTERCARD":
              $('#nameWithdraw').html('Номер карты:');
              $('#walletNumber').attr('placeholder', '541207XXXX785577');
							$('#walletNumber').val('5412');
              break;
          }
        }
        select();
        $('#hide_search').change(function() {
          select();
        });
      });
    });

    function send(event) {
      var id = $(event.target)[0].id;
      $.ajax({
          type: 'POST',
          url: '/inc/engine.php',
          data: {
              type: "otmena",
              sid: Cookies.get('sid'),
              idout: id
          },
          success: function(data) {
              var obj = jQuery.parseJSON(data);
              if (obj.success == "success") {
                  $('#emptyHistory').hide();
                  $('#withdrawT').html(obj.update_bd);
                  updateBalance(obj.balance, obj.new_balance);
              }
          }
      });
    }

   function register_show() {
                $('#login').hide();
                $('#reset').hide();
                $("#register").fadeIn("slow", function() {});
            }

            function login_show() {
                $('#register').hide();
                $('#reset').hide();
                $("#login").fadeIn("slow", function() {});
            }

            function reset_show() {
                $('#login').hide();
                $('#register').hide();
                $("#reset").fadeIn("slow", function() {});
            }
            function getContent(timestamp) {
                var queryString = {
                    'timestamp': timestamp
                };

                $.ajax({
                    type: 'GET',
                    url: 'longpool/server/server.php?rr=',
                    data: queryString,
                    success: function(data) {
                        var obj = jQuery.parseJSON(data);
						if (obj.data_from_file != ""){
							$('#response').html(obj.data_from_file);
						}

                        getContent(obj.timestamp);
                    }
                });
            }
 window.renderRecaptchas = function() {
        var recaptchas = document.querySelectorAll('.g-recaptcha');
        for (var i = 0; i < recaptchas.length; i++) {
            grecaptcha.render(recaptchas[i], {
                sitekey: recaptchas[i].getAttribute('data-sitekey')
            });
        }
    }

                                                                    function login() {
                                                                        if ($('#userLogin').val().length < 4) {
                                                                            $('#error_enter').css('display', 'block');
                                                                            return $('#error_enter').html('Логин от 4 символов');
                                                                        }
                                                                        if ($('#userPass').val() == '') {
                                                                            $('#error_enter').css('display', 'block');
                                                                            return $('#error_enter').html('Введите пароль');
                                    																		}
                                                                        if ($('#g-recaptcha-response').val() == '') {
                                                                            $('#error_enter').css('display', 'block');
                                                                            return $('#error_enter').html('Поставьте галочку в капче');
                                                                        }
                                                                        $.ajax({
                                                                            type: 'POST',
                                                                            url: '/inc/engine.php',
                                                                            beforeSend: function() {
                                                                                $('#error_enter').css('display', 'none');
                                                                                $('#loader').css('position', '');
                                                                                $('#enter_but').css('pointer-events', 'none');
                                                                                $('#dot-container').css('display', '');
                                                                                $('#text_enter').css('display', 'none');
                                                                                $('#text_enter').css('display', 'none');
                                                                            },
                                                                            data: {
                                                                                type: "login",
                                                                                login: $('#userLogin').val(),
                                                                                rc: $('#g-recaptcha-response').val(),
                                                                                pass: $('#userPass').val(),
                                                                            },
                                                                            success: function(data) {

                                                                                var obj = jQuery.parseJSON(data);
                                                                                if (obj.success == "success") {
                                                                                    Cookies.set('sid', obj.sid, { expires: 365,path: '/',secure:true });
																					Cookies.set('uid', obj.uid, { expires: 365,path: '/',secure:true });
																					Cookies.set('login', $('#userLogin').val(), { expires: 365,path: '/',secure:true });
																					window.location.href = '';
																					// return false;
                                                                                }else{
																				grecaptcha.reset();
																				$('#enter_but').css('pointer-events', '');
                                                                                $('#loader').css('position', 'absolute');
                                                                                $('#dot-container').css('display', 'none');
                                                                                $('#text_enter').css('display', 'block');
																				$('#error_enter').html(obj.error);
                                                                                $('#error_enter').css('display', 'block');
																				}


                                                                            }
                                                                        });

	  }
$('#userLoginRegister').keydown(function(event) {
                                                                            if (event.which === 13) {
                                                                                register1();

                                                                            }
                                                                        });
                                                                        $('#userEmailRegister').keydown(function(event) {
                                                                            if (event.which === 13) {
                                                                                register1();

                                                                            }
                                                                        });
                                                                        $('#userPassRegister').keydown(function(event) {
                                                                            if (event.which === 13) {
                                                                                register1();

                                                                            }
                                                                        });
                                                                        var input = document.getElementById('userLoginRegister'),
                                                                            value = input.value;

                                                                        input.addEventListener('input', onInput);

                                                                        function onInput(e) {
                                                                            var newValue = e.target.value;
                                                                            if (newValue.match(/[^a-zA-Z0-9]/g)) {
                                                                                input.value = value;
                                                                                return;
                                                                            }
                                                                            value = newValue;
                                                                        }

                                                                        var input2 = document.getElementById('userEmailRegister'),
                                                                            value = input2.value;

                                                                        input2.addEventListener('input', onInput1);

                                                                        function onInput1(e) {
                                                                            var newValue = e.target.value;
                                                                            if (newValue.match(/[^a-zA-Z0-9@.-_-]/g)) {
                                                                                input2.value = value;
                                                                                return;
                                                                            }
                                                                            value = newValue;
                                                                        }

                                                                        function isValidEmailAddress(email) {
                                                                            var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,5})(\]?)$/;
                                                                            return expr.test(email);
                                                                        };

                                                                        function register1() {
                                                                            if ($('#userLoginRegister').val().length < 4) {
                                                                                $('#error_register').css('display', 'block');
                                                                                return $('#error_register').html('Логин от 4 до 15 символов');
                                                                            }
                                                                            if ($('#userEmailRegister').val() == '') {
                                                                                $('#error_register').css('display', 'block');
                                                                                return $('#error_register').html('Введите email');
                                                                            }
                                                                            if (!isValidEmailAddress($('#userEmailRegister').val())) {
                                                                                $('#error_register').css('display', 'block');
                                                                                return $('#error_register').html('Введите корректный email');
                                                                            }
                                                                            if ($('#userPassRegister').val() == '') {
                                                                                $('#error_register').css('display', 'block');
                                                                                return $('#error_register').html('Введите пароль');
                                                                            }
                                                                            if ($('#userPassRegister').val().length < 5) {
                                                                                $('#error_register').css('display', 'block');
                                                                                return $('#error_register').html('Пароль от 5 символов');
                                                                            }
                                                                            if ($('#userPassRegister1').val() == '') {
                                                                                $('#error_register').css('display', 'block');
                                                                                return $('#error_register').html('Повторите пароль');
                                                                            }
                                                                            if ($('#userPassRegister1').val().length < 5) {
                                                                                $('#error_register').css('display', 'block');
                                                                                return $('#error_register').html('Пароль от 5 символов');
                                                                            }
                                                                            if ($('#userPassRegister1').val() != $('#userPassRegister').val()) {
                                                                                $('#error_register').css('display', 'block');
                                                                                return $('#error_register').html('Пароли не совпадают');
                                                                            }
								                                                            if (!$("#rulesagree").prop('checked')) {
                                                                                $('#error_register').css('display', 'block');
                                                                                return $('#error_register').html('Согласитесь с правилами');
                                                                            }
                                                                            if ($('#g-recaptcha-response-1').val() == '') {
                                                                                $('#error_register').css('display', 'block');
                                                                                return $('#error_register').html('Поставьте галочку в капче');
                                                                         	  }


                                                                            $.ajax({
                                                                                type: 'POST',
                                                                                url: '/inc/engine.php',
                                                                                beforeSend: function() {
                                                                                    $('#error_register').css('display', 'none');
                                                                                    $('#loader_register').css('position', '');
                                                                                    $('#enter_but').css('pointer-events', 'none');
                                                                                    $('#dot-container_register').css('display', '');
                                                                                    $('#text_register').css('display', 'none');

                                                                                },
                                                                                data: {
                                                                                    type: "register",
                                                                                    login: $('#userLoginRegister').val(),
                                                                                    rc: $('#g-recaptcha-response-1').val(),
                                                                                    pass: $('#userPassRegister').val(),
                                                                                    email: $('#userEmailRegister').val(),
								                                                                    ref: Cookies.get('ref')
                                                                                },
                                                                                success: function(data) {
                                                                                    $('#enter_but').css('pointer-events', '');


                                                                                    var obj = jQuery.parseJSON(data);
                                                                                     if (obj.success == 'success') {
                                                                                        Cookies.set('sid', obj.sid, { expires: 365,path: '/',secure:true });
																						Cookies.set('login', $('#userLoginRegister').val(), { expires: 365,path: '/',secure:true });
																						document.location.href = '';
																						 return false;
                                                                                    }else{
                                            grecaptcha.reset(1);
																						$('#error_register').html(obj.error);
																						$('#error_register').css('display', 'block');
																						$('#text_register').css('display', 'block');
																						$('#loader_register').css('position', 'absolute');
																						$('#dot-container_register').css('display', 'none');
																					}



                                                                                }
                                                                            });
                                                                        }
var input22 = document.getElementById('loginemail'),
                                                                            value = input22.value;

                                                                        input22.addEventListener('input', onInput1);

                                                                        function onInput1(e) {
                                                                            var newValue = e.target.value;
                                                                            if (newValue.match(/[^a-zA-Z0-9@.-]/g)) {
                                                                                input22.value = value;
                                                                                return;
                                                                            }
                                                                            value = newValue;
                                                                        }
																	$('#loginemail').keydown(function(event) {
                                                                            if (event.which === 13) {
                                                                                reset_password();

                                                                            }
                                                                        });
																	function reset_password() {

                                                                            if ($('#loginemail').val().length < 4) {
                                                                                $('#error_reset').css('display', 'block');
                                                                                return $('#error_reset').html('Введите корректные данные');
                                                                            }
                                                                            if ($('#g-recaptcha-response-2').val() == '') {
                                                                                $('#error_reset').css('display', 'block');
                                                                                return $('#error_reset').html('Поставьте галочку в капче');
                                                                         	  }


                                                                            $.ajax({
                                                                                type: 'POST',
                                                                                url: '/inc/engine.php',
                                                                                beforeSend: function() {
                                                                                    $('#error_reset').css('display', 'none');
                                                                                    $('#loader_reset').css('position', '');
																																										$('#reset_success').css('display', 'none');
                                                                                    $('#reset_but').css('pointer-events', 'none');
                                                                                    $('#dot-container_reset').css('display', '');
                                                                                    $('#text_reset').css('display', 'none');

                                                                                },
                                                                                data: {
                                                                                    type: "resetPass",
                                                                                    rc: $('#g-recaptcha-response-2').val(),
                                                                                    login: $('#loginemail').val()
                                                                                },
                                                                                success: function(data) {
                                                                                    $('#reset_but').css('pointer-events', '');
                                                                                    var obj = jQuery.parseJSON(data);
                                                                                    if (obj.success == "success") {
																																											grecaptcha.reset(2);
                                                                                      $('#gtt').show();
																						$('#reset_success').css('display', '');
																						$('#reset_success').html(obj.mesa);
																						$('#reset_but').css('display', 'none');
																						$('#loginemail').val('');
																						setTimeout(function() {
																							$('#reset_success').css('display', 'none');
																							$('#reset_but').css('display', 'block');
																						  $('#loader_reset').css('position', 'none');
																						  $('#dot-container_reset').css('display', 'none');
																							$('#gtt').hide();
																							$('#text_reset').css('display', '');
																							$('#loader_reset').css('position', 'absolute');
																						},7000);
                                            return false;
                                                                                    }else{
                                            grecaptcha.reset(2);
																					  $('#loader_reset').css('position', 'absolute');
																						$('#reset_but').css('display', '');
																						$('#dot-container_reset').css('display', 'none');
																						$('#text_reset').css('display', '');
																						$('#error_reset').html(obj.error);
																						$('#error_reset').css('display', 'block');

																					}






                                                                                }
                                                                            });
                                                                        }



									function resetPass() {
										if ($('#resetPass').val() == ''){
										$('#error_resetPass').show();
										return $('#error_resetPass').html('Введите пароль');
										}
										if ($('#resetPass').val().length < 5){
										$('#error_resetPass').show();
										return $('#error_resetPass').html('Пароль от 5 символов');
										}
									if ($('#resetPass').val() != $('#resetPassRepeat').val()){
										$('#error_resetPass').show();
										return $('#error_resetPass').html('Пароли не совпадают');
									}
									$.ajax({
                                        type: 'POST',
                                        url: '/inc/engine.php',
										beforeSend: function() {
											$('#error_resetPass').hide();
											$('#succes_resetPass').hide();
										},
                                        data: {
                                            type: "resetPassPanel",
                                            sid: Cookies.get('sid'),
                                            newPass: $('#resetPass').val()
                                        },
                                        success: function(data) {
                                            var obj = jQuery.parseJSON(data);
                                            if (obj.success == "success") {
                                               $("#succes_resetPass").show();
											  Cookies.set('sid', obj.sid, { path: '/',secure:true });
																						 return false;
                                            }else{
												$('#error_resetPass').show();
												return $('#error_resetPass').html(obj.error);
											}
                                        }
                                    });

                                }

function active() {
										if ($('#promo').val() == ''){
										$('#error_promo').show();
										return $('#error_promo').html('Введите Промокод');
										}

									$.ajax({
                                        type: 'POST',
                                        url: '/inc/engine.php',
										beforeSend: function() {
											$('#error_promo').hide();
											$('#succes_promo').hide();
										},
                                        data: {
                                            type: "PromoActive",
                                            sid: Cookies.get('sid'),
                                            promo: $('#promo').val()
                                        },
                                        success: function(data) {
                                            var obj = jQuery.parseJSON(data);
                                            if (obj.success == "success") {
                                               $("#succes_promo").show();
											   $("#succes_promo").html("Промокод на сумму <b>" + obj.suma + " </b> "+wallet+" Активирован");
											   $('#userBalance').attr('myBalance', obj.new_balance);
                                               updateBalance(obj.balance, obj.new_balance);
																						 return false;
                                            }else{
												$('#error_promo').show();
												return $('#error_promo').html(obj.error);
											}
                                        }
                                    });

                                }

            function updateBalance(start, end) {

                var el = document.getElementById('userBalance');

                od = new Odometer({
                    el: el,
                    value: start
                });

                od.update(end);
            }

            function updateHash() {

                // var audio = new Audio();
                // audio.src = 'Notify.mp3';
                // audio.volume = 0.1;
                // audio.autoplay = true;

                $.ajax({
                    type: 'POST',
                    url: '/inc/engine.php',
                    beforeSend: function() {
                        $('#checkBet').css('display', 'none');
                        $('#loader_hash').css('display', '');
                        $('#betStart').css('opacity', '0.25');
                        $('#controlBet').css('opacity', '0.25');
                        $('#betStart').css('pointer-events', 'none');
                        $('#controlBet').css('pointer-events', 'none');
                        $('#hashBet').html('');
                    },
                    data: {
                        type: "updateHash",
                        hid: $('#hashBet').attr('hid'),
                    },
                    success: function(data) {

                        var obj = jQuery.parseJSON(data);
                        if (obj.success == "success") {

                            $('#checkBet').css('display', '');
                            Cookies.set('hid', obj.hid, { path: '/',secure:true });
                            $('#hashBet').attr('hid', obj.hid);
                            $('#hashBet').html(obj.hash);
                            $('#loader_hash').css('display', 'none');
                            $('#betStart').css('opacity', '');
                            $('#controlBet').css('opacity', '');
                            $('#betStart').css('pointer-events', '');
                            $('#controlBet').css('pointer-events', '');

                            // setTimeout(updateHash, 89000);
                        }
                        sss();

                        if ('error' in obj) {
                            return document.location.href = '';
                        }

                    }
                });
            }

                                                                    function bet(type) {

                                                                        if ($('#userBalance').html() < $('#BetSize').val()) {
                                                                            $('#error_bet').html('Недостаточно средств');
                                                                            return $('#error_bet').css('display', '');
                                                                        }
																																				if($('#BetSize').val() < minbetsize)
																																				{
																																					$('#error_bet').html('Ставки от '+minbetsize+' '+wallet);
                                                                            return $('#error_bet').css('display', '');
																																				}
                                                                        $.ajax({
                                                                            type: 'POST',
                                                                            url: '/inc/engine.php',
                                                                            beforeSend: function() {
                                                                                $('#checkBet').css('display', 'none');
                                                                                $('#error_bet').css('display', 'none')
                                                                                $('#succes_bet').css('display', 'none')
                                                                                $('#betLoad').css('display', '');
                                                                                $('#buttonMax').css('pointer-events', 'none');
                                                                                $('#buttonMin').css('pointer-events', 'none');
                                                                            },
                                                                            data: {
                                                                                type: type,
                                                                                sid: Cookies.get('sid'),
                                                                                 hid: $('#hashBet').attr('hid'),
                                                                                betSize: $('#BetSize').val(),
                                                                                betPercent: $('#BetPercent').val(),
                                                                            },
                                                                            success: function(data) {
                                                                                $('#buttonMax').css('pointer-events', '');
                                                                                $('#buttonMin').css('pointer-events', '');
                                                                                $('#betLoad').css('display', 'none');
                                                                                var obj = jQuery.parseJSON(data);
                                                                                if (obj.success == "success") {
                                                                                    $('#checkBet').css('display', '');

                                                                                   $('#checkBet').attr('href', 'game?id=' + obj.check_bet);
                                                                                    if (obj.type == 'win') {
                                                                                        // var audio = new Audio();
                                                                                        // audio.src = 'Coin.mp3';
                                                                                        // audio.volume = 0.6;
                                                                                        // audio.autoplay = true;
                                                                                        $('#succes_bet').css('display', '');
                                                                                        $("#succes_bet").html("Победа. Вы выиграли <b>" + obj.profit + " </b> "+wallet);
                                                                                    }
                                                                                    if (obj.type == 'lose') {

                                                                                        $('#error_bet').css('display', '');
                                                                                        $("#error_bet").html("Проигрыш. Выпало число  " + obj.number);
                                                                                    }
                                                                                    $("#hashBet").html(obj.hash);
                                                                                    Cookies.set('hid', obj.hid, { path: '/',secure:true });
                                                                                    $('#hashBet').attr('hid', obj.hid);
                                                                                    sss();
																					//updateHash();
                                                                                    $('#userBalance').attr('myBalance', obj.new_balance);
                                                                                    updateBalance(obj.balance, obj.new_balance);
                                                                                }
                                                                                if (obj.success == "error") {
                                                                                    $('#error_bet').html(obj.error);
                                                                                    return $('#error_bet').css('display', '');
                                                                                }

                                                                            }
                                                                        });

                                                                    }

                                                                    function updateProfit() {
                                                                        $('#BetProfit').html(((100 / $('#BetPercent').val()) * $('#BetSize').val()).toFixed(2));
                                                                        $('#MinRange').html(Math.floor(($('#BetPercent').val() / 100) * 999999));
                                                                        $('#MaxRange').html(999999 - Math.floor(($('#BetPercent').val() / 100) * 999999));
                                                                    if($('#BetPercent').val() <= 0)
																	{
																		updateProfit();
																	}
																	if($('#BetSize').val() <= 0)
																	{
																		updateProfit();
																	}
																	}

                                                                    function sss() {
                                                                        $('#hashBet').fadeOut('slow', function() {
                                                                            $('#hashBet').fadeIn('slow', function() {

                                                                            });
                                                                        });
                                                                    }
                                                                    $('#BetPercent').keyup(function() {
                                                                        $('#BetProfit').html(((100 / $('#BetPercent').val()) * $('#BetSize').val()).toFixed(2));
                                                                        $('#MinRange').html(Math.floor(($('#BetPercent').val() / 100) * 999999));
                                                                        $('#MaxRange').html(999999 - Math.floor(($('#BetPercent').val() / 100) * 999999));
                                                                    });
                                                                    $('#BetSize').keyup(function() {
                                                                        $('#MinRange').html(Math.floor(($('#BetPercent').val() / 100) * 999999));
                                                                        $('#MaxRange').html(999999 - Math.floor(($('#BetPercent').val() / 100) * 999999));
                                                                        $('#BetProfit').html(((100 / $('#BetPercent').val()) * $('#BetSize').val()).toFixed(2));
                                                                    });

					function deposit() {
						if ( $('#systemPay').val() > 3 || !$.isNumeric($('#systemPay').val())){
							$('#error_deposit').show();
							return $('#error_deposit').html('Укажите систему пополнения');
						}
						if ($('#depositSize').val() == ''){
							$('#error_deposit').show();
							return $('#error_deposit').html('Введите сумму');
						}
						if (!$.isNumeric($('#depositSize').val())){
							$('#error_deposit').show();
							return $('#error_deposit').html('Введите корректную сумму');
						}
						$.ajax({
                    type: 'POST',
                    url: '/inc/engine.php',
                    data: {
                        type: "deposit",
                        sid: Cookies.get('sid'),
                        system: $('#systemPay').val(),
                        size: $('#depositSize').val()
                    },
                    success: function(data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj.success == "success") {
							 $('#depositLoad').show();
							window.location.href = obj.locations;
                        }

                        if (obj.success == "error") {
                            $('#error_deposit').show();
                            return $('#error_deposit').html(obj.error);
                        }

                    }
                });

					}

            function withdraw() {
                if ($('#WithdrawSize').val() == '' || $('#walletNumber').val() == '' || $('#hide_search').val() == '') {
                    $('#error_withdraw').show();
                    return $('#error_withdraw').html('Заполните все поля');
                }
                if ($('#walletNumber').val().length < 8) {
                    $('#error_withdraw').show();
                    return $('#error_withdraw').html('Номер/Кошелек от 8 цифр');
                }

                $.ajax({
                    type: 'POST',
                    url: '/inc/engine.php',
                    beforeSend: function() {
                        $('#withdrawB').html('');
                        $('#error_withdraw').hide();
                        $('#succes_withdraw').hide();
                        $('#loader').css('display', '');
                    },
                    data: {
                        type: "withdraw",
                        sid: Cookies.get('sid'),
                        system: $('#hide_search').val(),
                        size: $('#WithdrawSize').val(),
                        wallet: $('#walletNumber').val()
                    },
                    success: function(data) {


                        $('#withdrawB').html('Выплата');

                        $('#loader').css('display', 'none');
                        var obj = jQuery.parseJSON(data);
                        if (obj.success == "success") {
				                    $('#emptyHistory').hide();
                            $('#succes_withdraw').show();
                            var tt = $('#withdrawT').html();
                            $('#withdrawT').html(obj.add_bd + tt);
                            updateBalance(obj.balance, obj.new_balance);
                            setTimeout(function() {
                              $('#WithdrawSize').val('');
                              $('#walletNumber').val('');
                              $('#succes_withdraw').hide();
                            }, 2500);
                        }

                        if (obj.success == "error") {
                            $('#error_withdraw').show();
                            return $('#error_withdraw').html(obj.error);
                        }

                    }
                });
            }

        function emojis(emoj){
	$("#emojiArea").append('<img src="/img/emojis/'+emoj+'.png" style="width: 25px; height: 25px;" alt="'+emoj+'">');
};
