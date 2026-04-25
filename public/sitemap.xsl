<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xhtml="http://www.w3.org/1999/xhtml">

    <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>

    <xsl:template match="/">
        <html lang="en">
        <head>
            <meta charset="UTF-8"/>
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <title>Sitemap</title>
            <style>
                * { box-sizing: border-box; margin: 0; padding: 0; }
                body { font-family: 'Segoe UI', Arial, sans-serif; background: #0f0f0f; color: #e5e7eb; min-height: 100vh; }
                .header { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); padding: 40px; border-bottom: 3px solid; border-image: linear-gradient(90deg, #f97316, #ef4444) 1; }
                .header h1 { font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 8px; }
                .header p { color: rgba(255,255,255,0.5); font-size: 14px; }
                .badge { display: inline-block; background: rgba(249,115,22,0.15); border: 1px solid rgba(249,115,22,0.3); color: #f97316; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-top: 12px; }
                .container { max-width: 1100px; margin: 0 auto; padding: 40px 20px; }
                .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 32px; }
                .stat { background: #1a1a1a; border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 20px; text-align: center; }
                .stat-num { font-size: 32px; font-weight: 800; color: #f97316; }
                .stat-label { font-size: 12px; color: rgba(255,255,255,0.4); margin-top: 4px; text-transform: uppercase; letter-spacing: 1px; }
                table { width: 100%; border-collapse: collapse; background: #1a1a1a; border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.06); }
                thead tr { background: #242424; }
                th { padding: 14px 20px; text-align: left; font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; }
                td { padding: 14px 20px; border-top: 1px solid rgba(255,255,255,0.04); font-size: 13px; vertical-align: middle; }
                tr:hover td { background: rgba(255,255,255,0.02); }
                .url-link { color: #f97316; text-decoration: none; word-break: break-all; }
                .url-link:hover { text-decoration: underline; }
                .priority-high { color: #22c55e; font-weight: 700; }
                .priority-med { color: #f97316; font-weight: 600; }
                .priority-low { color: rgba(255,255,255,0.4); }
                .freq { background: rgba(255,255,255,0.05); padding: 3px 10px; border-radius: 20px; font-size: 11px; color: rgba(255,255,255,0.5); }
                .date { color: rgba(255,255,255,0.35); font-size: 12px; }
                .footer { text-align: center; padding: 30px; color: rgba(255,255,255,0.2); font-size: 12px; }
            </style>
        </head>
        <body>
            <div class="header">
                <div style="max-width:1100px;margin:0 auto;">
                    <h1>&#x1F5FA; XML Sitemap</h1>
                    <p>This sitemap is automatically generated and updated dynamically.</p>
                    <span class="badge">&#x2713; Valid Sitemap</span>
                </div>
            </div>
            <div class="container">
                <div class="stats">
                    <div class="stat">
                        <div class="stat-num"><xsl:value-of select="count(sitemap:urlset/sitemap:url)"/></div>
                        <div class="stat-label">Total URLs</div>
                    </div>
                    <div class="stat">
                        <div class="stat-num"><xsl:value-of select="count(sitemap:urlset/sitemap:url[sitemap:priority = '1.0'])"/></div>
                        <div class="stat-label">High Priority</div>
                    </div>
                    <div class="stat">
                        <div class="stat-num"><xsl:value-of select="count(sitemap:urlset/sitemap:url[sitemap:changefreq = 'weekly'])"/></div>
                        <div class="stat-label">Weekly Updated</div>
                    </div>
                    <div class="stat">
                        <div class="stat-num"><xsl:value-of select="count(sitemap:urlset/sitemap:url[sitemap:changefreq = 'monthly'])"/></div>
                        <div class="stat-label">Monthly Updated</div>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>URL</th>
                            <th>Last Modified</th>
                            <th>Change Freq</th>
                            <th>Priority</th>
                        </tr>
                    </thead>
                    <tbody>
                        <xsl:for-each select="sitemap:urlset/sitemap:url">
                            <tr>
                                <td style="color:rgba(255,255,255,0.2);width:40px;"><xsl:value-of select="position()"/></td>
                                <td>
                                    <a class="url-link" href="{sitemap:loc}">
                                        <xsl:value-of select="sitemap:loc"/>
                                    </a>
                                </td>
                                <td class="date"><xsl:value-of select="substring(sitemap:lastmod,1,10)"/></td>
                                <td><span class="freq"><xsl:value-of select="sitemap:changefreq"/></span></td>
                                <td>
                                    <xsl:choose>
                                        <xsl:when test="sitemap:priority = '1.0'">
                                            <span class="priority-high"><xsl:value-of select="sitemap:priority"/></span>
                                        </xsl:when>
                                        <xsl:when test="sitemap:priority &gt;= '0.7'">
                                            <span class="priority-med"><xsl:value-of select="sitemap:priority"/></span>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <span class="priority-low"><xsl:value-of select="sitemap:priority"/></span>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </td>
                            </tr>
                        </xsl:for-each>
                    </tbody>
                </table>
            </div>
            <div class="footer">
                Generated dynamically &#x2022; <xsl:value-of select="count(sitemap:urlset/sitemap:url)"/> URLs indexed
            </div>
        </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
