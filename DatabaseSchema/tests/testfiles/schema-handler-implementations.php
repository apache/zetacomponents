<?php
class TestSchemaReaderImplementation implements ezcDbSchemaReader
{
    public function getReaderType()
    {
        return ezcDbSchema::FILE;
    }
}
class TestSchemaWriterImplementation implements ezcDbSchemaWriter
{
    public function getWriterType()
    {
        return ezcDbSchema::FILE;
    }
}
class TestSchemaDiffReaderImplementation implements ezcDbSchemaDiffReader
{
    public function getDiffReaderType()
    {
        return ezcDbSchema::FILE;
    }
}
class TestSchemaDiffWriterImplementation implements ezcDbSchemaDiffWriter
{
    public function getDiffWriterType()
    {
        return ezcDbSchema::FILE;
    }
}
?>
