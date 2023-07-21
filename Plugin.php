<?php

/**
 * 一个能快速添加页脚标识功能的小插件
 * 
 * @package Biaoshi
 * @author 诺依阁
 * @version 1.0.0
 * @link https://blog.nuoyis.com
 */
class Biaoshi_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        \Widget\Options::alloc()->to($options);
        /*if ($options->theme == "butterfly"){
        Typecho_Widget::widget('Widget_Options')->theme('butterfly')->Customfooter() .= array('Biaoshi_Plugin', 'Biaoshi_footer');
        return 'butterfly用户欢迎使用本备案标识插件';
        }else{*/
        Typecho_Plugin::factory('Widget_Archive')->footer = array('Biaoshi_Plugin', 'Biaoshi_footer');
        return '欢迎使用本备案标识插件，请注意主题布局是否包含系统footer';
        /*}*/
    }
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
    {
        return '';
    }

    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        //备案开启
        $Biaoshiof = new Typecho_Widget_Helper_Form_Element_Radio(
            'Biaoshiof',
            array(
                'on' => _t('开启备案标识'),
                'off' => _t('关闭备案标识'),
            ),
            'off',
            _t('开启则将自动插入到主题中')
        );
        $form->addInput($Biaoshiof);
        $gxBiaoshi = new Typecho_Widget_Helper_Form_Element_Text('gxBiaoshi', NULL,_t(''), _t('工信部备案'), _t('仅填写备案号即可,除广东省地区其他地区必须带-(数字),如果还不懂请点击<a href="https://help.aliyun.com/document_detail/137270.htm">这里</a>'));
        $gxBiaoshi->setAttribute('id', 'gxBiaoshi');
        $form->addInput($gxBiaoshi);
    
        $gaBiaoshi = new Typecho_Widget_Helper_Form_Element_Text('gaBiaoshi', NULL,_t(''), _t('公安备案'), _t('仅填写备案号即可不懂请点击<a href="http://wap.qianfanyun.com/help/1397">这里</a>'));
        $form->addInput($gaBiaoshi);
    
        $moeBiaoshi = new Typecho_Widget_Helper_Form_Element_Text('moeBiaoshi', NULL,_t(''), _t('萌国备案'), _t('娱乐使用，申请点击<a href="https://icp.gov.moe/">这里</a>'));
        $form->addInput($moeBiaoshi);
        
        $upyun = new Typecho_Widget_Helper_Form_Element_Select('upyun',
        array(
            'on' => '开启',
            'off' => '关闭(默认)',
        ),
        'off',
        '是否显示又拍云赞助',
        '介绍：又拍云可每月使用15g流量，但需要底部悬挂又拍云的引流链接，注册地址:https://upyun.com'
        );
        $form->addInput($upyun);
    }

    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
    }

    /**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
    public static function render()
    {
    }
    
    public static function Biaoshi_footer()
    {
    $Biaoshimu='';
    $dir=Helper::options()->pluginUrl . "/" . basename(dirname(__FILE__));
    $Biaoshimu.= <<<HTML
    <style>
    .nuoyis-footer{
        bottom: 0;
        z-index: 999999;
        color: white;
        position: relative;
        text-align: center;
        background-image: linear-gradient(to top, #fad0c4 0%, #fad0c4 1%, #ffd1ff 100%);
        padding: 8px 20px;
    }
    
    .nuoyis-footer a{
        text-decoration: none;
        color: inherit;
    }
    </style>
    <div class="nuoyis-footer" style="">
HTML;
     if(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->Biaoshiof != "off" && Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->gxBiaoshi != ""):
    $gxBiaoshi = Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->gxBiaoshi;
    $Biaoshimu.= <<<HTML
    备案号:<a href="//Biaoshi.miit.gov.cn">{$gxBiaoshi}</a>
HTML;
    if(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->gaBiaoshi != "") $Biaoshimu.= " | ";
    endif;
    if(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->Biaoshiof != "off" && Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->gaBiaoshi != ""): 
    if (is_string(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->gaBiaoshi) || !empty(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->gaBiaoshi)):
    $gaBiaoshi1 = $gaBiaoshi2 = '';
    if (is_string(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->gaBiaoshi) || !empty(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->gaBiaoshi)){
    for ($i = 0; $i < strlen(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->gaBiaoshi); $i++) {
    $char = substr(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->gaBiaoshi, $i, 1);
    if (ctype_digit($char)) {
    $gaBiaoshi1=substr(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->gaBiaoshi, 0, $i);
    $gaBiaoshi2=substr(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->gaBiaoshi, $i, strlen(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->gaBiaoshi)-$i-3);
    break;
        }
      } 
    }
    $Biaoshimu.= <<<HTML
        <img src="{$dir}/img/beian.png">{$gaBiaoshi1}<a href="//www.Biaoshi.gov.cn/portal/registerSystemInfo?recordcode={$gaBiaoshi2}">{$gaBiaoshi2}</a>号 
HTML;
    if(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->moeBiaoshi != "") $Biaoshimu.= " | ";
    endif;endif;
    if(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->Biaoshiof != "off" && Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->moeBiaoshi != ""): 
    if (is_string(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->moeBiaoshi) || !empty(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->moeBiaoshi)):
    $moeBiaoshi1 = $moeBiaoshi2 = '';
    if (is_string(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->moeBiaoshi) || !empty(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->moeBiaoshi)){
    for ($i = 0; $i < strlen(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->moeBiaoshi); $i++) {
    $char = substr(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->moeBiaoshi, $i, 1);
    if (ctype_digit($char)) {
    $moeBiaoshi1=substr(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->moeBiaoshi, 0, $i);
    $moeBiaoshi2=substr(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->moeBiaoshi, $i, strlen(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->moeBiaoshi)-$i-3);
    break;
        }
      }
    }
    $Biaoshimu.= <<<HTML
        {$moeBiaoshi1}<a href="https://icp.gov.moe/?keyword=<?=$moeBiaoshi2; ?>" target="_blank">{$moeBiaoshi2}</a>号
HTML;
    endif;endif;
    if(Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->upyun == "on")
    {
    if(!Typecho_Widget::widget('Widget_Options')->Plugin('Biaoshi')->Biaoshiof == "on") $Biaoshimu.= " | ";
    $Biaoshimu.= <<<HTML
    全站由<a target="_BLANK" href="https://www.upyun.com/?utm_source=lianmeng&amp;utm_medium=referral" title="又拍云CDN" alt="又拍云CDN"><img src="{$dir}/img/upyun_logo.webp" style="margin-bottom: -10px;margin-left: 3px" alt="CDN" width="70" height="35" data-ll-status="loading" class="entered loading"></a>提供CDN加速/云存储服务</div>
HTML;
    }
    $Biaoshimu.= <<<HTML
    </div>
HTML;
    echo $Biaoshimu;
    }
}
