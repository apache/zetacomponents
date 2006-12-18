create or replace function md5(
vin_string IN varchar2
) return varchar2 IS
--
-- Return an MD5 hash of the input string.
--
BEGIN
return lower(dbms_obfuscation_toolkit.md5 (
input => utl_raw.cast_to_raw(vin_string)
));
END;
/
exit;