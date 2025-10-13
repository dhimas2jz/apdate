USE apdate;

DROP FUNCTION IF EXISTS fn_status_siswa;

DELIMITER $$
CREATE FUNCTION `fn_status_siswa`(p_siswa_id INT, p_field VARCHAR(100)) RETURNS varchar(100) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
    DETERMINISTIC
BEGIN
    DECLARE v_result VARCHAR(100);

    IF p_field = 'status' THEN
        SELECT status INTO v_result
        FROM tref_kelas_siswa
        WHERE siswa_id = p_siswa_id
        ORDER BY id DESC
        LIMIT 1;

    ELSEIF p_field = 'kelas_id' THEN
        SELECT kelas_id INTO v_result
        FROM tref_kelas_siswa
        WHERE siswa_id = p_siswa_id
        ORDER BY id DESC
        LIMIT 1;

    ELSE
        SELECT id INTO v_result
        FROM tref_kelas_siswa
        WHERE siswa_id = p_siswa_id
        ORDER BY id DESC
        LIMIT 1;
    END IF;

    RETURN v_result;
END$$
DELIMITER ;
