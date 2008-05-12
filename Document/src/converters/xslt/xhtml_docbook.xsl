<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" 
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
                xmlns:fo="http://www.w3.org/1999/XSL/Format" 
                xmlns:html="http://www.w3.org/1999/xhtml" 
                xmlns:set="http://exslt.org/sets"
                xmlns:dyn="http://exslt.org/dynamic"
                extension-element-prefixes="set dyn"
                exclude-result-prefixes="xsl fo html">

<xsl:output method="xml"
            indent="yes"
            doctype-public="-//OASIS//DTD Simplified DocBook XML V1.0//EN"
            doctype-system="http://www.oasis-open.org/docbook/xml/simple/1.0/sdocbook.dtd"/>
            
<!--<xsl:param name="filename"></xsl:param> 
<xsl:param name="prefix">wb</xsl:param>-->
<xsl:param name="graphics_location">file:///path/to/graphics/</xsl:param>

<!-- Main block-level conversions -->
<xsl:template match="html:html">
 <article>
 <xsl:apply-templates select="html:head"/>
 <xsl:apply-templates select="html:body"/>
 </article>
</xsl:template>

<!-- HTML Title -->
<xsl:template match="html:head">
    <articleinfo>
        <xsl:apply-templates select='html:title'/>
    </articleinfo>
</xsl:template>

<xsl:template match="html:title">
    <title><xsl:value-of select='.'/></title>
</xsl:template>

<!-- HTML Body -->
<xsl:template match="html:body">
     <!-- Render everything before the first header -->
     <xsl:apply-templates select='set:leading(following-sibling::*,following-sibling::html:h1)'/>
     <!-- Render level 1 headers -->
     <xsl:apply-templates select="html:h1"/>
</xsl:template>

<xsl:template match="html:h1|html:h2|html:h3|html:h4|html:h5|html:h6">
  <section>
   <title>
    <xsl:apply-templates/>
   </title>

   <xsl:variable name='level' select="number(substring-after(name(),'h'))"/>
   <!-- Make a string like "following-sibling::html:h2|following-sibling::html:h1" (for level=2)-->
   <xsl:variable name='fheaders'>
    <xsl:call-template name = "make_header_string">
     <xsl:with-param name="num" select="$level"/>
    </xsl:call-template>
   </xsl:variable>
   <!-- Make a string like "following-sibling::html:h3|following-sibling::html:h2|following-sibling::html:h1" (for level=2)-->
   <xsl:variable name='fheaders1'>
    <xsl:call-template name = "make_header_string">
     <xsl:with-param name="num" select="$level + 1"/>
    </xsl:call-template>
   </xsl:variable>

   <!-- Render all the following-sibling elements before headers -->
   <xsl:apply-templates select='set:leading(following-sibling::*,dyn:evaluate($fheaders1))'/>
     
   <!-- Render the following-sibling next level headers -->
   <xsl:apply-templates select="set:leading(dyn:evaluate($fheaders1),dyn:evaluate($fheaders))"/>
   
  </section>
</xsl:template>

<xsl:template name="make_header_string">
 <xsl:param name="num"/>
 <xsl:if test="not($num = 0)">
  <xsl:text>following-sibling::html:h</xsl:text>
  <xsl:value-of select="$num"/>
  <xsl:if test="not($num = 1)">
  <xsl:text>|</xsl:text>
  </xsl:if>
  <xsl:call-template name = "make_header_string">
   <xsl:with-param name="num" select="$num - 1" />
  </xsl:call-template>
 </xsl:if>
</xsl:template>
        
<!-- These templates perform one-to-one conversions of HTML elements into
     DocBook elements -->
<xsl:template match="html:p">
<!-- if the paragraph has no text (perhaps only a child <img>), don't 
     make it a para
     
     TODO: Control with a setting?
     
 <xsl:choose>
  <xsl:when test="normalize-space(.) = ''">
   <xsl:apply-templates/>
  </xsl:when>
  <xsl:otherwise>-->
 <para>
  <xsl:apply-templates/>
 </para>
<!--  </xsl:otherwise>
 </xsl:choose>-->
</xsl:template>

<!-- Hyperlinks -->
<xsl:template match="html:a[contains(@href,'http://') or contains(@href,'ftp://')]" priority="1.5">
 <ulink>
  <xsl:attribute name="url">
   <xsl:value-of select="normalize-space(@href)"/>
  </xsl:attribute>
  <xsl:apply-templates/>
 </ulink>
</xsl:template>

<xsl:template match="html:a[contains(@href,'#')]" priority="0.5">
 <link>
  <xsl:attribute name="linkend">
   <xsl:value-of select="substring-after(@href,'#')"/>
  </xsl:attribute>
 </link>
</xsl:template>

<xsl:template match="html:a[@name != '']" priority="0.5">
 <anchor>
  <xsl:attribute name="id">
   <xsl:value-of select="@name"/>
  </xsl:attribute>
 </anchor>
</xsl:template>

<!-- Images -->
<!-- Images and image maps -->
<xsl:template match="html:img">
 <xsl:variable name="tag_name">
  <xsl:choose>
   <xsl:when test="boolean(parent::html:p)">
    <xsl:text>inlinemediaobject</xsl:text>
   </xsl:when>
   <xsl:otherwise>
    <xsl:text>mediaobject</xsl:text>
   </xsl:otherwise>
  </xsl:choose>
 </xsl:variable>
 <xsl:element name="{$tag_name}">
  <imageobject>
   <xsl:call-template name="process.image"/>
  </imageobject>
 </xsl:element>
</xsl:template>

<xsl:template name="process.image">
 <imagedata>
<xsl:attribute name="fileref">
 <xsl:choose>
  <xsl:when test="contains(@src,'http://')">
   <xsl:value-of select="@src"/>
  </xsl:when>
  <xsl:otherwise>
   <xsl:call-template name="make_absolute">
    <xsl:with-param name="filename" select="@src"/>
   </xsl:call-template>
  </xsl:otherwise>
 </xsl:choose>
</xsl:attribute>
<xsl:if test="@height != ''">
 <xsl:attribute name="depth">
  <xsl:value-of select="@height"/>
 </xsl:attribute>
</xsl:if>
<xsl:if test="@width != ''">
 <xsl:attribute name="width">
  <xsl:value-of select="@width"/>
 </xsl:attribute>
</xsl:if>
 </imagedata>
</xsl:template>

<xsl:template name="make_absolute">
 <xsl:param name="src"/>
 <xsl:variable name="name_only">
  <xsl:call-template name="get_filename">
   <xsl:with-param name="path" select="$src"/>
  </xsl:call-template>
 </xsl:variable>
 <xsl:value-of select="$graphics_location"/><xsl:value-of select="$name_only"/>
</xsl:template>

<xsl:template name="get_filename">
 <xsl:param name="path"/>
 <xsl:choose>
  <xsl:when test="contains($path,'/')">
   <xsl:call-template name="get_filename">
    <xsl:with-param name="path" select="substring-after($path,'/')"/>
   </xsl:call-template>
  </xsl:when>
  <xsl:otherwise>
   <xsl:value-of select="$path"/>
  </xsl:otherwise>
 </xsl:choose>
</xsl:template>

<!-- inline formatting -->
<xsl:template match="html:b | html:strong">
 <emphasis role="strong">
  <xsl:apply-templates/>
 </emphasis>
</xsl:template>

<xsl:template match="html:i | html:em | html:emphasize">
 <emphasis>
  <xsl:apply-templates/>
 </emphasis>
</xsl:template>

<xsl:template match="html:u">
 <citetitle>
  <xsl:apply-templates/>
 </citetitle>
</xsl:template>

<xsl:template match="html:tt">
 <literal>
  <xsl:apply-templates/>
 </literal>
</xsl:template>

<xsl:template match="html:sub">
 <subscript>
  <xsl:apply-templates/>
 </subscript>
</xsl:template>

<xsl:template match="html:sup">
 <superscript>
  <xsl:apply-templates/>
 </superscript>
</xsl:template>

<xsl:template match="html:acronym">
 <acronym>
  <xsl:apply-templates/>
 </acronym>
</xsl:template>

<xsl:template match="html:q">
 <quote>
  <xsl:apply-templates/>
 </quote>
</xsl:template>

<xsl:template match="html:cite">
 <citetitle>
  <xsl:apply-templates/>
 </citetitle>
</xsl:template>

<!-- LIST ELEMENTS -->
<xsl:template match="html:ul">
 <itemizedlist>
  <xsl:apply-templates/>
 </itemizedlist>
</xsl:template>

<xsl:template match="html:ol">
 <orderedlist>
  <xsl:apply-templates/>
 </orderedlist>
</xsl:template>
        
<!-- This template makes a DocBook variablelist out of an HTML definition list -->
<xsl:template match="html:dl">
 <variablelist>
  <xsl:for-each select="html:dt">
   <varlistentry>
    <term>
     <xsl:apply-templates/>
    </term>
    <listitem>
     <xsl:apply-templates select="following-sibling::html:dd[1]"/>
    </listitem>
   </varlistentry>
  </xsl:for-each>
 </variablelist>
</xsl:template>

<xsl:template match="html:dd">
 <xsl:choose>
  <xsl:when test="boolean(html:p)">
   <xsl:apply-templates/>
  </xsl:when>
  <xsl:otherwise>
   <para>
    <xsl:apply-templates/>
   </para>
  </xsl:otherwise>
 </xsl:choose>
</xsl:template>

<xsl:template match="html:li">
 <listitem>
  <xsl:choose>
   <xsl:when test="count(html:p) = 0">
    <para>
     <xsl:apply-templates/>
    </para>
   </xsl:when>
   <xsl:otherwise>
    <xsl:apply-templates/>
   </xsl:otherwise>
  </xsl:choose>
 </listitem>
</xsl:template>

<!-- Table conversion -->
<xsl:template match="html:table">
 <xsl:variable name="tag_name">
  <xsl:choose>
    <xsl:when test="boolean(./html:caption)">
     <xsl:text>table</xsl:text>
    </xsl:when>
    <xsl:otherwise>
     <xsl:text>informaltable</xsl:text>
    </xsl:otherwise>
   </xsl:choose>
 </xsl:variable>
 <xsl:element name="{$tag_name}">
  <xsl:if test="$tag_name = 'table'">
   <title>
    <xsl:value-of select='./html:caption'/>
   </title>
  </xsl:if>
  <tgroup>
   <xsl:variable name="column_count">
    <xsl:call-template name="count_columns">
     <xsl:with-param name="table" select="."/>
    </xsl:call-template>
   </xsl:variable>
   <xsl:attribute name="cols">
    <xsl:value-of select="$column_count"/>
   </xsl:attribute>
   <xsl:call-template name="generate-colspecs">
    <xsl:with-param name="count" select="$column_count"/>
   </xsl:call-template>
   <xsl:apply-templates/>
  </tgroup>
 </xsl:element>
</xsl:template>

<xsl:template name="generate-colspecs">
 <xsl:param name="count" select="0"/>
 <xsl:param name="number" select="1"/>
 <xsl:choose>
  <xsl:when test="$count &lt; $number"/>
  <xsl:otherwise>
   <colspec>
    <xsl:attribute name="colnum">
     <xsl:value-of select="$number"/>
    </xsl:attribute>
    <xsl:attribute name="colname">
     <xsl:value-of select="concat('col',$number)"/>
    </xsl:attribute>
   </colspec>
   <xsl:call-template name="generate-colspecs">
    <xsl:with-param name="count" select="$count"/>
    <xsl:with-param name="number" select="$number + 1"/>
   </xsl:call-template>
  </xsl:otherwise>
 </xsl:choose>
</xsl:template>

<xsl:template match="html:tbody">
 <tbody>
  <xsl:apply-templates/>
 </tbody>
</xsl:template>

<xsl:template match="html:thead">
 <thead>
  <xsl:apply-templates/>
 </thead>
</xsl:template>

<xsl:template match="html:tr">
 <row>
  <xsl:apply-templates/>
 </row>
</xsl:template>

<xsl:template match="html:th|html:td">
 <xsl:variable name="position" select="count(preceding-sibling::*) + 1"/>
 <entry>
  <xsl:if test="@colspan &gt; 1">
   <xsl:attribute name="namest">
    <xsl:value-of select="concat('col',$position)"/>
   </xsl:attribute>
   <xsl:attribute name="nameend">
    <xsl:value-of select="concat('col',$position + number(@colspan) - 1)"/>
   </xsl:attribute>
  </xsl:if>
  <xsl:if test="@rowspan &gt; 1">
   <xsl:attribute name="morerows">
    <xsl:value-of select="number(@rowspan) - 1"/>
   </xsl:attribute>
  </xsl:if>
  <xsl:apply-templates/>
 </entry>
</xsl:template>

<xsl:template match="html:td_null">
 <xsl:apply-templates/>
</xsl:template>

<xsl:template name="count_columns">
 <xsl:param name="table" select="."/>
 <xsl:param name="max" select="0"/>
 <xsl:param name="row" select="$table/html:tr[1]|$table/html:tbody/html:tr[1]"/>
 <!-- Count cells in the current row -->
 <xsl:variable name="current_count">
  <xsl:call-template name="count_cells">
   <xsl:with-param name="cell" select="$row/html:td[1]|$row/html:th[1]"/>
  </xsl:call-template>
 </xsl:variable>
 <!-- Check for the maximum value of $current_count and $max -->
 <xsl:variable name="new_max">
  <xsl:choose>
   <xsl:when test="$current_count &gt; $max">
    <xsl:value-of select="number($current_count)"/>
   </xsl:when>
   <xsl:otherwise>
    <xsl:value-of select="number($max)"/>
   </xsl:otherwise>
  </xsl:choose>
 </xsl:variable>
 <!-- If this is the last row, return $max, otherwise continue -->
 <xsl:choose>
  <xsl:when test="count($row/following-sibling::html:tr) = 0">
   <xsl:value-of select="$new_max"/>
  </xsl:when>
  <xsl:otherwise>
   <xsl:call-template name="count_columns">
    <xsl:with-param name="table" select="$table"/>
    <xsl:with-param name="row" select="$row/following-sibling::html:tr"/>
    <xsl:with-param name="max" select="$new_max"/>
   </xsl:call-template>
  </xsl:otherwise>
 </xsl:choose>
</xsl:template>

<xsl:template name="count_cells">
 <xsl:param name="cell"/>
 <xsl:param name="count" select="0"/>
 <xsl:variable name="new_count">
  <xsl:choose>
   <xsl:when test="$cell/@colspan &gt; 1">
    <xsl:value-of select="number($cell/@colspan) + number($count)"/>
   </xsl:when>
   <xsl:otherwise>
    <xsl:value-of select="number('1') + number($count)"/>
   </xsl:otherwise>
  </xsl:choose>
 </xsl:variable>
 <xsl:choose>
  <xsl:when test="count($cell/following-sibling::*) &gt; 0">
   <xsl:call-template name="count_cells">
    <xsl:with-param name="cell"
                    select="$cell/following-sibling::*[1]"/>
    <xsl:with-param name="count" select="$new_count"/>
   </xsl:call-template>
  </xsl:when>
  <xsl:otherwise>
   <xsl:value-of select="$new_count"/>
  </xsl:otherwise>
 </xsl:choose>
</xsl:template>

<!-- Other block elements -->

<xsl:template match="html:pre">
 <literallayout>
  <xsl:apply-templates/>
 </literallayout>
</xsl:template>

<xsl:template match="html:code">
 <programlisting>
  <xsl:apply-templates/>
 </programlisting>
</xsl:template>

<xsl:template match="html:blockquote">
 <blockquote>
  <xsl:apply-templates/>
 </blockquote>
</xsl:template>

<!-- Ignored elements -->
<xsl:template match="html:hr"/>
<xsl:template match="html:br"/>
<xsl:template match="html:caption"/>
<!--<xsl:template match="html:p[normalize-space(.) = '' and count(*) = 0]"/>-->
<xsl:template match="text()">
 <xsl:choose>
  <xsl:when test="normalize-space(.) = ''"></xsl:when>
  <xsl:otherwise><xsl:copy/></xsl:otherwise>
 </xsl:choose>
</xsl:template>

<!-- Not matched elements warnings -->
<xsl:template match="*">
 <xsl:message>No template for <xsl:value-of select="name()"/>
 </xsl:message>
 <xsl:apply-templates/>
</xsl:template>

<xsl:template match="@*">
 <xsl:message>No template for <xsl:value-of select="name()"/>
 </xsl:message>
 <xsl:apply-templates/>
</xsl:template>

</xsl:stylesheet>
