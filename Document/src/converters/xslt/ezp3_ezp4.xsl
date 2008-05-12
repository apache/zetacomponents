<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" 
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"                 
                xmlns:set="http://exslt.org/sets"
                xmlns:dyn="http://exslt.org/dynamic"
                xmlns:php="http://php.net/xsl"
                extension-element-prefixes="set dyn php"
                exclude-result-prefixes="xsl">

<xsl:output method="xml" indent="yes" />
            
<!-- Main block-level conversions -->
<xsl:template match="section">
 <xsl:param name="level" select="0"/>
 <xsl:choose>  
  <xsl:when test="$level = 0">
   <document>
    <xsl:apply-templates>
     <xsl:with-param name="level" select="$level + 1"/>
    </xsl:apply-templates>
   </document>
  </xsl:when>
  <xsl:otherwise>
   <xsl:apply-templates>
     <xsl:with-param name="level" select="$level + 1"/>
    </xsl:apply-templates>
  </xsl:otherwise>
 </xsl:choose>
</xsl:template>

<xsl:template match="paragraph">
   <xsl:apply-templates mode="common"/>
</xsl:template>

<xsl:template match="header">
 <xsl:param name="level"/>
  <xsl:element name="h{$level - 1}">
   <xsl:apply-templates mode="common"/>
  </xsl:element>
</xsl:template>

<!-- A common template for inline tags -->
<xsl:template name="inline_common" match="line|strong|emphasize|embed-inline|anchor|link|text()" mode="common">
 <xsl:choose>
   <!-- If a parent is paragraph -->
   <xsl:when test="boolean(parent::paragraph)">
    <!-- We call render_para template only for the first inline tag,
         all the following inline tags are rendered inside that template. -->
    <xsl:if test="boolean(count(preceding-sibling::node()))">
     <xsl:variable name="prevname" select="name(preceding-sibling::node()[1])" />
     <!-- Check that the previous tag is not inline
          TODO: add all block tags -->
     <xsl:if test="($prevname = 'embed') or ($prevname = 'table') or ($prevname = 'ol') or ($prevname = 'ul') or ($prevname = 'literal')  or ($prevname = 'custom')">
      <xsl:call-template name='render_para' />
     </xsl:if>
    </xsl:if>
    <!-- Check that there is no previous element (current is the first child) -->
    <xsl:if test="(count(preceding-sibling::node()) = 0)">
     <xsl:call-template name='render_para' />
    </xsl:if>
   </xsl:when>
   <xsl:otherwise>
    <xsl:apply-templates mode='special' select='.'/>
   </xsl:otherwise>
 </xsl:choose>
</xsl:template>

<xsl:template name="render_para">
 <p>
  <!-- Copy attributes of parent paragraph -->
  <xsl:copy-of select="parent::paragraph/@*" />
  <xsl:apply-templates mode="special" select="."/>
  <xsl:apply-templates mode="special" select="set:leading(following-sibling::node(),following-sibling::*[name() = 'embed' or name() = 'table' or name() = 'ol' or name() = 'ul' or name() = 'literal' or name() = 'custom'])"/>
 </p>
</xsl:template>
 
<!-- Common template for block tags -->
<xsl:template match="embed|table|tr|td|th|ol|ul|li|literal|custom" mode='common'>
 <xsl:choose>
  <xsl:when test="name() = 'custom' and dyn:evaluate(php:function('ezcDocumentEzp3ToEzp4Converter::getCustomInlineTags'))">
   <xsl:call-template name='inline_common'/>
  </xsl:when>
  <xsl:when test="name() = 'embed'">
   <xsl:apply-templates mode="special" select="."/>
  </xsl:when>
  <xsl:otherwise>
   <xsl:copy>
    <xsl:copy-of select="@*" />
    <xsl:apply-templates mode='common'/>
   </xsl:copy>
  </xsl:otherwise>
 </xsl:choose>
</xsl:template>

<!-- Specific templates for tags -->
<xsl:template match='embed|embed-inline' mode='special'>
 <xsl:copy>
    <xsl:copy-of select="@*[name() != 'href']" />
    <xsl:attribute name='src'>
     <xsl:value-of select='@href'/>
    </xsl:attribute>
    <xsl:apply-templates/>
 </xsl:copy>
</xsl:template>

<xsl:template match="line" mode="special">
   <xsl:apply-templates mode="common"/>
   <xsl:variable name="nextname" select="name(following-sibling::node()[1])" />
   <xsl:if test="boolean(count(following-sibling::node()))
                 and ($nextname != 'embed') and ($nextname != 'table') and ($nextname != 'ol') and ($nextname != 'ul') and ($nextname != 'literal') and ($nextname != 'custom')">
    <br />
   </xsl:if>
</xsl:template>

<xsl:template match="link" mode="special">
 <xsl:copy>
  <xsl:copy-of select="@*[name() != 'target']" />
  <xsl:apply-templates/>
 </xsl:copy>
</xsl:template>

<xsl:template match="text()" mode="special">
 <xsl:choose>
  <xsl:when test="normalize-space(.) = ''"></xsl:when>
  <xsl:otherwise><xsl:copy/></xsl:otherwise>
 </xsl:choose>
</xsl:template>

<!-- For all other inline tags -->
<xsl:template match="strong|emphasize|anchor|custom" mode="special">
 <xsl:copy>
  <xsl:copy-of select="@*" />
  <xsl:apply-templates/>
 </xsl:copy>
</xsl:template>

</xsl:stylesheet>
