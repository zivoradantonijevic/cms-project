<?php
/**
 * @link      http://www.writesdown.com/
 * @author    Agiel K. Saputra <13nightevil@gmail.com>
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

use cms\models\Option;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<xsl:stylesheet version="2.0" xmlns:html="http://www.w3.org/TR/REC-html40"
                xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
    <xsl:template match="/">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title><?= Option::get('sitetitle') . ' - ' . Yii::t('cms', 'XML Sitemap'); ?></title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <style type="text/css">
                body {
                    font-family: Helvetica, Arial, sans-serif;
                    font-size: 13px;
                    color: #545353;
                }
                table {
                    border: none;
                    border-collapse: collapse;
                    width: 100%;
                }
                #sitemap tr.odd td {
                    background-color: #eee !important;
                }
                #sitemap tbody tr:hover td {
                    background-color: #ccc;
                }
                #sitemap tbody tr:hover td, #sitemap tbody tr:hover td a {
                    color: #000;
                }
                #content {
                    margin: 0 auto;
                    width: 1000px;
                }
                .expl {
                    margin: 18px 3px;
                    line-height: 1.2em;
                }
                .expl a {
                    color: #da3114;
                    font-weight: bold;
                }
                .expl a:visited {
                    color: #da3114;
                }
                a {
                    color: #000;
                    text-decoration: none;
                }
                a:visited {
                    color: #777;
                }
                a:hover {
                    text-decoration: underline;
                }
                td {
                    font-size: 11px;
                }
                th {
                    text-align: left;
                    padding-right: 30px;
                    font-size: 11px;
                }
                thead th {
                    border-bottom: 1px solid #000;
                    cursor: pointer;
                }
            </style>
        </head>
        <body>
        <div id="content">
            <h1>XML Sitemap</h1>

            <p class="expl">
                <?= Yii::t(
                    'cms',
                    'Generated by {writesDownLink}. More Information about XML Sitemaps on {sitemapLink}', [
                        'writesDownLink' => Html::a('cms', 'http://www.writesdown.com'),
                        'sitemapLink'    => Html::a('sitemaps.org', 'http://sitemaps.org'),
                    ]
                ) ?>
            </p>
            <xsl:if test="count(sitemap:sitemapindex/sitemap:sitemap) &gt; 0">
                <p class="expl">
                    <?= Yii::t('cms', 'This XML Sitemap Index file contains {countSitemap} sitemaps.', [
                        'countSitemap' => '<xsl:value-of select="count(sitemap:sitemapindex/sitemap:sitemap)"/>',
                    ]) ?>
                </p>
                <table id="sitemap" cellpadding="3">
                    <thead>
                    <tr>
                        <th width="75%"><?= Yii::t('cms', 'Sitemap') ?></th>
                        <th width="25%"><?= Yii::t('cms', 'Last Modified') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <xsl:for-each select="sitemap:sitemapindex/sitemap:sitemap">
                        <xsl:variable name="sitemapURL">
                            <xsl:value-of select="sitemap:loc"/>
                        </xsl:variable>
                        <tr>
                            <td>
                                <a href="{$sitemapURL}">
                                    <xsl:value-of select="sitemap:loc"/>
                                </a>
                            </td>
                            <td>
                                <xsl:value-of
                                    select="concat(substring(sitemap:lastmod,0,11),concat(' ', substring(sitemap:lastmod,12,5)))"/>
                            </td>
                        </tr>
                    </xsl:for-each>
                    </tbody>
                </table>
            </xsl:if>
            <xsl:if test="count(sitemap:sitemapindex/sitemap:sitemap) &lt; 1">
                <p class="expl">
                    <?= Yii::t('cms', 'This XML Sitemap contains {countSitemap} URLs', [
                        'countSitemap' => '<xsl:value-of select="count(sitemap:urlset/sitemap:url)"/>',
                    ]) ?>
                </p>

                <p class="expl"><?= Html::a(Yii::t('cms', '&#8593; Sitemap Index'),
                        Yii::$app->urlManager->hostInfo . Url::to(['index'])) ?></p>
                <table id="sitemap" cellpadding="3">
                    <thead>
                    <tr>
                        <th width="75%"><?= Yii::t('cms', 'URL') ?></th>
                        <th title="Index Priority" width="5%"><?= Yii::t('cms', 'Prio') ?></th>
                        <th width="5%"><?= Yii::t('cms', 'Images') ?></th>
                        <th title="Change Frequency" width="5%"><?= Yii::t('cms', 'Ch. Freq.') ?></th>
                        <th title="Last Modification Time" width="10%"><?= Yii::t('cms', 'Last Mod.') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <xsl:variable name="lower" select="'abcdefghijklmnopqrstuvwxyz'"/>
                    <xsl:variable name="upper" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZ'"/>
                    <xsl:for-each select="sitemap:urlset/sitemap:url">
                        <tr>
                            <td>
                                <xsl:variable name="itemURL">
                                    <xsl:value-of select="sitemap:loc"/>
                                </xsl:variable>
                                <a href="{$itemURL}">
                                    <xsl:value-of select="sitemap:loc"/>
                                </a>
                            </td>
                            <td>
                                <xsl:value-of select="concat(sitemap:priority*100,'%')"/>
                            </td>
                            <td>
                                <xsl:value-of select="count(image:image)"/>
                            </td>
                            <td>
                                <xsl:value-of
                                    select="concat(translate(substring(sitemap:changefreq, 1, 1),concat($lower, $upper),concat($upper, $lower)),substring(sitemap:changefreq, 2))"/>
                            </td>
                            <td>
                                <xsl:value-of
                                    select="concat(substring(sitemap:lastmod,0,11),concat(' ', substring(sitemap:lastmod,12,5)))"/>
                            </td>
                        </tr>
                    </xsl:for-each>
                    </tbody>
                </table>
            </xsl:if>
        </div>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script type="text/javascript"
                src="//cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.21.5/js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript"><![CDATA[
            $(document).ready(function () {
                $("#sitemap").tablesorter({widgets: ['zebra']});
            });
            ]]></script>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
