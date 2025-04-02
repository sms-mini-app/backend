<?php
namespace app\helpers;

class CrcHelper {
    const VERSION_MAJOR            = 2;
    const VERSION_MINOR            = 3;
    const VERSION_PATCH            = 0;

    const CRC_CHECK_DATA           = "123456789";

    const CRC8_AUTOSAR_CHECK       = 0xdf;
    const CRC8_BLUETOOTH_CHECK     = 0x26;
    const CRC8_CDMA2000_CHECK      = 0xda;
    const CRC8_DARC_CHECK          = 0x15;
    const CRC8_DVB_S2_CHECK        = 0xbc;
    const CRC8_GSM_A_CHECK         = 0x37;
    const CRC8_GSM_B_CHECK         = 0x94;
    const CRC8_HITAG_CHECK         = 0xb4;
    const CRC8_I_432_1_CHECK       = 0xa1;
    const CRC8_I_CODE_CHECK        = 0x7e;
    const CRC8_LTE_CHECK           = 0xea;
    const CRC8_MAXIM_DOW_CHECK     = 0xa1;
    const CRC8_MIFARE_MAD_CHECK    = 0x99;
    const CRC8_NRSC_5_CHECK        = 0xf7;
    const CRC8_OPENSAFETY_CHECK    = 0x3e;
    const CRC8_ROHC_CHECK          = 0xd0;
    const CRC8_SAE_J1850_CHECK     = 0x4b;
    const CRC8_SMBUS_CHECK         = 0xf4;
    const CRC8_TECH_3250_CHECK     = 0x97;
    const CRC8_WCDMA_CHECK         = 0x25;

    const CRC16_A_CHECK            = 0xbf05;
    const CRC16_ARC_CHECK          = 0xbb3d;
    const CRC16_CDMA2000_CHECK     = 0x4c06;
    const CRC16_CMS_CHECK          = 0xaee7;
    const CRC16_DDS_110_CHECK      = 0x9ecf;
    const CRC16_DECT_R_CHECK       = 0x007e;
    const CRC16_DECT_X_CHECK       = 0x007f;
    const CRC16_DNP_CHECK          = 0xea82;
    const CRC16_EN_13757_CHECK     = 0xc2b7;
    const CRC16_GENIBUS_CHECK      = 0xd64e;
    const CRC16_GSM_CHECK          = 0xce3c;
    const CRC16_IBM_3740_CHECK     = 0x29b1;
    const CRC16_IBM_SDLC_CHECK     = 0x906e;
    const CRC16_KERMIT_CHECK       = 0x2189;
    const CRC16_LJ1200_CHECK       = 0xbdf4;
    const CRC16_M17_CHECK          = 0x772b;
    const CRC16_MAXIM_DOW_CHECK    = 0x44c2;
    const CRC16_MCRF4XX_CHECK      = 0x6f91;
    const CRC16_MODBUS_CHECK       = 0x4b37;
    const CRC16_NRSC_5_CHECK       = 0xa066;
    const CRC16_OPENSAFETY_A_CHECK = 0x5d38;
    const CRC16_OPENSAFETY_B_CHECK = 0x20fe;
    const CRC16_PROFIBUS_CHECK     = 0xa819;
    const CRC16_RIELLO_CHECK       = 0x63d0;
    const CRC16_SPI_FUJITSU_CHECK  = 0xe5cc;
    const CRC16_T10_DIF_CHECK      = 0xd0db;
    const CRC16_TELEDISK_CHECK     = 0x0fb3;
    const CRC16_TMS37157_CHECK     = 0x26b1;
    const CRC16_UMTS_CHECK         = 0xfee8;
    const CRC16_USB_CHECK          = 0xb4c8;
    const CRC16_XMODEM_CHECK       = 0x31c3;

    const CRC24_BLE_CHECK          = 0xc25a56;
    const CRC24_FLEXRAY_A_CHECK    = 0x7979bd;
    const CRC24_FLEXRAY_B_CHECK    = 0x1f23b8;
    const CRC24_INTERLAKEN_CHECK   = 0xb4f3e6;
    const CRC24_LTE_A_CHECK        = 0xcde703;
    const CRC24_LTE_B_CHECK        = 0x23ef52;
    const CRC24_OPENPGP_CHECK      = 0x21cf02;
    const CRC24_OS_9_CHECK         = 0x200fa5;

    const CRC32_AIXM_CHECK         = 0x3010bf7f;
    const CRC32_AUTOSAR_CHECK      = 0x1697d06a;
    const CRC32_BASE91_D_CHECK     = 0x87315576;
    const CRC32_BZIP2_CHECK        = 0xfc891918;
    const CRC32_CD_ROM_EDC_CHECK   = 0x6ec2edc4;
    const CRC32_CKSUM_CHECK        = 0x765e7680;
    const CRC32_ISCSI_CHECK        = 0xe3069283;
    const CRC32_ISO_HDLC_CHECK     = 0xcbf43926;
    const CRC32_JAMCRC_CHECK       = 0x340bc6d9;
    const CRC32_MEF_CHECK          = 0xd2c22f51;
    const CRC32_MPEG_2_CHECK       = 0x0376e6e7;
    const CRC32_XFER_CHECK         = 0xbd0be338;

    const CRC64_ECMA_182_CHECK     = "6c40df5f0b497347";
    const CRC64_GO_ISO_CHECK       = "b90956c775a41001";
    const CRC64_MS_CHECK           = "75d4b74f024eceea";
    const CRC64_WE_CHECK           = "62ec59e3f1a4f00a";
    const CRC64_XZ_CHECK           = "995dc9bbdf1939fa";

    /* CRC-8/AUTOSAR */
    public static function crc8_autosar(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x2f,
            ini:0xff,
            xor:0xff,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-8/BLUETOOTH */
    public static function crc8_bluetooth(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0xa7,
            ini:0x00,
            xor:0x00,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-8/CDMA2000 */
    public static function crc8_cdma2000(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x9b,
            ini:0xff,
            xor:0x00,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-8/DARC */
    public static function crc8_darc(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x39,
            ini:0x00,
            xor:0x00,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-8/DVB-S2 */
    public static function crc8_dvb_s2(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0xd5,
            ini:0x00,
            xor:0x00,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-8/GSM-A */
    public static function crc8_gsm_a(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x1d,
            ini:0x00,
            xor:0x00,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-8/GSM-B */
    public static function crc8_gsm_b(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x49,
            ini:0x00,
            xor:0xff,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-8/HITAG */
    public static function crc8_hitag(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x1d,
            ini:0xff,
            xor:0x00,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-8/I-432-1 */
    public static function crc8_i_432_1(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x07,
            ini:0x00,
            xor:0x55,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-8/I-CODE */
    public static function crc8_i_code(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x1d,
            ini:0xfd,
            xor:0x00,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-8/LTE */
    public static function crc8_lte(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x9b,
            ini:0x00,
            xor:0x00,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-8/MAXIM-DOW */
    public static function crc8_maxim_dow(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x31,
            ini:0x00,
            xor:0x00,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-8/MIFARE-MAD */
    public static function crc8_mifare_mad(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x1d,
            ini:0xc7,
            xor:0x00,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-8/NRSC-5 */
    public static function crc8_nrsc_5(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x31,
            ini:0xff,
            xor:0x00,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-8/OPENSAFETY */
    public static function crc8_opensafety(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x2f,
            ini:0x00,
            xor:0x00,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-8/ROHC */
    public static function crc8_rohc(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x07,
            ini:0xff,
            xor:0x00,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-8/SAE-J1850 */
    public static function crc8_sae_j1850(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x1d,
            ini:0xff,
            xor:0xff,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-8/SMBUS */
    public static function crc8_smbus(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x07,
            ini:0x00,
            xor:0x00,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-8/TECH-3250 */
    public static function crc8_tech_3250(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x1d,
            ini:0xff,
            xor:0x00,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-8/WCDMA */
    public static function crc8_wcdma(
        $str
    ): int {
        return self::crc8(
            str:$str,
            polynomial:0x9b,
            ini:0x00,
            xor:0x00,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-16/ISO-IEC-14443-3-A */
    public static function crc16_a(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x1021,
            ini:0xc6c6,
            xor:0x0000,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-16/ARC */
    public static function crc16_arc(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x8005,
            ini:0x0000,
            xor:0x0000,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-16/CDMA2000 */
    public static function crc16_cdma2000(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0xc867,
            ini:0xffff,
            xor:0x0000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/CMS */
    public static function crc16_cms(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x8005,
            ini:0xffff,
            xor:0x0000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/DDS-110 */
    public static function crc16_dds_110(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x8005,
            ini:0x800d,
            xor:0x0000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/DECT-R */
    public static function crc16_dect_r(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x0589,
            ini:0x0000,
            xor:0x0001,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/DECT-X */
    public static function crc16_dect_x(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x0589,
            ini:0x0000,
            xor:0x0000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/DNP */
    public static function crc16_dnp(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x3d65,
            ini:0x0000,
            xor:0xffff,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-16/EN-13757 */
    public static function crc16_en_13757(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x3d65,
            ini:0x0000,
            xor:0xffff,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/GENIBUS */
    public static function crc16_genibus(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x1021,
            ini:0xffff,
            xor:0xffff,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/GSM */
    public static function crc16_gsm(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x1021,
            ini:0x0000,
            xor:0xffff,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/IBM-3740 */
    public static function crc16_ibm_3740(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x1021,
            ini:0xffff,
            xor:0x0000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/IBM-SDLC */
    public static function crc16_ibm_sdlc(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x1021,
            ini:0xffff,
            xor:0xffff,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-16/KERMIT */
    public static function crc16_kermit(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x1021,
            ini:0x0000,
            xor:0x0000,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-16/LJ1200 */
    public static function crc16_lj1200(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x6f63,
            ini:0x0000,
            xor:0x0000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/M17 */
    public static function crc16_m17(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x5935,
            ini:0xffff,
            xor:0x0000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/MAXIM-DOW */
    public static function crc16_maxim_dow(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x8005,
            ini:0x0000,
            xor:0xffff,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-16/MCRF4XX */
    public static function crc16_mcrf4xx(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x1021,
            ini:0xffff,
            xor:0x0000,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-16/MODBUS */
    public static function crc16_modbus(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x8005,
            ini:0xffff,
            xor:0x0000,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-16/NRSC-5 */
    public static function crc16_nrsc_5(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x080b,
            ini:0xffff,
            xor:0x0000,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-16/OPENSAFETY-A */
    public static function crc16_opensafety_a(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x5935,
            ini:0x0000,
            xor:0x0000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/OPENSAFETY-B */
    public static function crc16_opensafety_b(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x755b,
            ini:0x0000,
            xor:0x0000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/PROFIBUS */
    public static function crc16_profibus(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x1dcf,
            ini:0xffff,
            xor:0xffff,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/RIELLO */
    public static function crc16_riello(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x1021,
            ini:0xb2aa,
            xor:0x0000,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-16/SPI-FUJITSU */
    public static function crc16_spi_fujitsu(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x1021,
            ini:0x1d0f,
            xor:0x0000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/T10-DIF */
    public static function crc16_t10_dif(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x8bb7,
            ini:0x0000,
            xor:0x0000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/TELEDISK */
    public static function crc16_teledisk(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0xa097,
            ini:0x0000,
            xor:0x0000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/TMS37157 */
    public static function crc16_tms37157(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x1021,
            ini:0x89ec,
            xor:0x0000,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-16/UMTS */
    public static function crc16_umts(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x8005,
            ini:0x0000,
            xor:0x0000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-16/USB */
    public static function crc16_usb(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x8005,
            ini:0xffff,
            xor:0xffff,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-16/XMODEM */
    public static function crc16_xmodem(
        $str
    ): int {
        return self::crc16(
            str:$str,
            polynomial:0x1021,
            ini:0x0000,
            xor:0x0000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-24/BLE */
    public static function crc24_ble(
        $str
    ): int {
        return self::crc24(
            str:$str,
            polynomial:0x00065b,
            ini:0x555555,
            xor:0x000000,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-24/FLEXRAY-A */
    public static function crc24_flexray_a(
        $str
    ): int {
        return self::crc24(
            str:$str,
            polynomial:0x5d6dcb,
            ini:0xfedcba,
            xor:0x000000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-24/FLEXRAY-B */
    public static function crc24_flexray_b(
        $str
    ): int {
        return self::crc24(
            str:$str,
            polynomial:0x5d6dcb,
            ini:0xabcdef,
            xor:0x000000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-24/INTERLAKEN */
    public static function crc24_interlaken(
        $str
    ): int {
        return self::crc24(
            str:$str,
            polynomial:0x328b63,
            ini:0xffffff,
            xor:0xffffff,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-24/LTE-A */
    public static function crc24_lte_a(
        $str
    ): int {
        return self::crc24(
            str:$str,
            polynomial:0x864cfb,
            ini:0x000000,
            xor:0x000000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-24/LTE-B */
    public static function crc24_lte_b(
        $str
    ): int {
        return self::crc24(
            str:$str,
            polynomial:0x800063,
            ini:0x000000,
            xor:0x000000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-24/OPENPGP */
    public static function crc24_openpgp(
        $str
    ): int {
        return self::crc24(
            str:$str,
            polynomial:0x864cfb,
            ini:0xb704ce,
            xor:0x000000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-24/OS-9 */
    public static function crc24_os_9(
        $str
    ): int {
        return self::crc24(
            str:$str,
            polynomial:0x800063,
            ini:0xffffff,
            xor:0xffffff,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-32/AIXM */
    public static function crc32_aixm(
        $str
    ): int {
        return self::crc32(
            str:$str,
            polynomial:0x814141ab,
            ini:0x00000000,
            xor:0x00000000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-32/AUTOSAR */
    public static function crc32_autosar(
        $str
    ): int {
        return self::crc32(
            str:$str,
            polynomial:0xf4acfb13,
            ini:0xffffffff,
            xor:0xffffffff,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-32/BASE91-D */
    public static function crc32_base91_d(
        $str
    ): int {
        return self::crc32(
            str:$str,
            polynomial:0xa833982b,
            ini:0xffffffff,
            xor:0xffffffff,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-32/BZIP2 */
    public static function crc32_bzip2(
        $str
    ): int {
        return self::crc32(
            str:$str,
            polynomial:0x04c11db7,
            ini:0xffffffff,
            xor:0xffffffff,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-32/CD-ROM-EDC */
    public static function crc32_cd_rom_edc(
        $str
    ): int {
        return self::crc32(
            str:$str,
            polynomial:0x8001801b,
            ini:0x00000000,
            xor:0x00000000,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-32/CKSUM */
    public static function crc32_cksum(
        $str
    ): int {
        return self::crc32(
            str:$str,
            polynomial:0x04c11db7,
            ini:0x00000000,
            xor:0xffffffff,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-32/ISCSI */
    public static function crc32_iscsi(
        $str
    ): int {
        return self::crc32(
            str:$str,
            polynomial:0x1edc6f41,
            ini:0xffffffff,
            xor:0xffffffff,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-32/ISO-HDLC */
    public static function crc32_iso_hdlc(
        $str
    ): int {
        return self::crc32(
            str:$str,
            polynomial:0x04c11db7,
            ini:0xffffffff,
            xor:0xffffffff,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-32/JAMCRC */
    public static function crc32_jamcrc(
        $str
    ): int {
        return self::crc32(
            str:$str,
            polynomial:0x04c11db7,
            ini:0xffffffff,
            xor:0x00000000,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-32/MEF */
    public static function crc32_mef(
        $str
    ): int {
        return self::crc32(
            str:$str,
            polynomial:0x741b8cd7,
            ini:0xffffffff,
            xor:0x00000000,
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-32/MPEG-2 */
    public static function crc32_mpeg_2(
        $str
    ): int {
        return self::crc32(
            str:$str,
            polynomial:0x04c11db7,
            ini:0xffffffff,
            xor:0x00000000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-32/XFER */
    public static function crc32_xfer(
        $str
    ): int {
        return self::crc32(
            str:$str,
            polynomial:0x000000af,
            ini:0x00000000,
            xor:0x00000000,
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-64/ECMA-182 */
    public static function crc64_ecma_182(
        $str
    ): int {
        return self::crc64(
            str:$str,
            polynomial:"42f0e1eba9ea3693",
            ini:"0000000000000000",
            xor:"0000000000000000",
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-64/GO-ISO */
    public static function crc64_go_iso(
        $str
    ): int {
        return self::crc64(
            str:$str,
            polynomial:"000000000000001b",
            ini:"ffffffffffffffff",
            xor:"ffffffffffffffff",
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-64/MS */
    public static function crc64_ms(
        $str
    ): int {
        return self::crc64(
            str:$str,
            polynomial:"259c84cba6426349",
            ini:"ffffffffffffffff",
            xor:"0000000000000000",
            ref_in:true,
            ref_out:true
        );
    }

    /* CRC-64/WE */
    public static function crc64_we(
        $str
    ): int {
        return self::crc64(
            str:$str,
            polynomial:"42f0e1eba9ea3693",
            ini:"ffffffffffffffff",
            xor:"ffffffffffffffff",
            ref_in:false,
            ref_out:false
        );
    }

    /* CRC-64/XZ */
    public static function crc64_xz(
        $str
    ): int {
        return self::crc64(
            str:$str,
            polynomial:"42f0e1eba9ea3693",
            ini:"ffffffffffffffff",
            xor:"ffffffffffffffff",
            ref_in:true,
            ref_out:true
        );
    }

    public static function crc8(
        $str,
        $polynomial,
        $ini,
        $xor,
        $ref_in,
        $ref_out
    ): int {
        if (!is_scalar($str))
            throw new \InvalidArgumentException(
                "Variable for CRC calculation must be a scalar."
            );

        $crc = $ini;

        for ($i = 0; $i < strlen($str); $i++) {
            $byte = ord($str[$i]);

            if ($ref_in)
                self::reflect_bits($byte, 8);

            $crc ^= $byte;

            for ($j = 0; $j < 8; $j++) {
                if ($crc & 0x80)
                    $crc = (($crc << 1) & 0xff) ^ $polynomial;
                else
                    $crc = ($crc << 1) & 0xff;
            }
        }

        $result = ($crc ^ $xor) & 0xff;

        if ($ref_out)
            self::reflect_bits($result, 8);

        return $result;
    }

    public static function crc16(
        $str,
        $polynomial,
        $ini,
        $xor,
        $ref_in,
        $ref_out
    ): int {
        if (!is_scalar($str))
            throw new \InvalidArgumentException(
                "Variable for CRC calculation must be a scalar."
            );

        $crc = $ini;

        for ($i = 0; $i < strlen($str); $i++) {
            $byte = ord($str[$i]);

            if ($ref_in)
                self::reflect_bits($byte, 8);

            $crc ^= $byte << 8;

            for ($j = 0; $j < 8; $j++) {
                if ($crc & 0x8000)
                    $crc = (($crc << 1) & 0xffff) ^ $polynomial;
                else
                    $crc = ($crc << 1) & 0xffff;
            }
        }

        $result = ($crc ^ $xor) & 0xffff;

        if ($ref_out)
            self::reflect_bits($result, 16);

        return $result;
    }

    public static function crc24(
        $str,
        $polynomial,
        $ini,
        $xor,
        $ref_in,
        $ref_out
    ): int {
        if (!is_scalar($str))
            throw new \InvalidArgumentException(
                "Variable for CRC calculation must be a scalar."
            );

        $crc = $ini;

        for ($i = 0; $i < strlen($str); $i++) {
            $byte = ord($str[$i]);

            if ($ref_in)
                self::reflect_bits($byte, 8);

            $crc ^= $byte << 16;

            for ($j = 0; $j < 8; $j++) {
                $crc = (($crc << 1) & 0xffffffff);

                if ($crc & 0x1000000)
                    $crc ^= $polynomial;
            }
        }

        $result = ($crc ^ $xor) & 0xffffff;

        if ($ref_out)
            self::reflect_bits($result, 24);

        return $result;
    }

    public static function crc32($str,
                                 $polynomial,
                                 $ini,
                                 $xor,
                                 $ref_in,
                                 $ref_out
    ): int {
        if (PHP_INT_SIZE < 8)
            throw new \RuntimeException(
                "CRC-32 calculation requires 64-bit integers."
            );

        if (!is_scalar($str))
            throw new \InvalidArgumentException(
                "Variable for CRC calculation must be a scalar."
            );

        $crc = $ini;

        for ($i = 0; $i < strlen($str); $i++) {
            $byte = ord($str[$i]);

            if ($ref_in)
                self::reflect_bits($byte, 8);

            $crc ^= $byte << 24;

            for ($j = 0; $j < 8; $j++) {
                if ($crc & 0x80000000)
                    $crc = (($crc << 1) & 0xffffffff) ^ $polynomial;
                else
                    $crc = ($crc << 1) & 0xffffffff;
            }
        }

        $result = ($crc ^ $xor) & 0xffffffff;

        if ($ref_out)
            self::reflect_bits($result, 32);

        return $result;
    }

    public static function crc64(
        $str,
        $polynomial,
        $ini,
        $xor,
        $ref_in,
        $ref_out
    ): int {
        if (PHP_INT_SIZE < 8)
            throw new \RuntimeException(
                "CRC-64 calculation requires 64-bit integers."
            );

        if (!is_scalar($str))
            throw new \InvalidArgumentException(
                "Variable for CRC calculation must be a scalar."
            );

        self::unpack_uint64($polynomial);
        self::unpack_uint64($ini);
        self::unpack_uint64($xor);

        $crc = $ini;
        $x80 = "8000000000000000";
        $xff = "ffffffffffffffff";

        self::unpack_uint64($x80);
        self::unpack_uint64($xff);

        for ($i = 0; $i < strlen($str); $i++) {
            $byte = ord($str[$i]);

            if ($ref_in)
                self::reflect_bits($byte, 8);

            $crc ^= $byte << 56;

            for ($j = 0; $j < 8; $j++) {
                if ($crc & $x80)
                    $crc = (($crc << 1) & $xff) ^ $polynomial;
                else
                    $crc = ($crc << 1) & $xff;
            }
        }

        $result = ($crc ^ $xor) & -1;

        if ($ref_out)
            self::reflect_bits($result, 64);

        return $result;
    }

    public static function test_crc8(
    ): array {
        return self::test_crc("crc8");
    }

    public static function test_crc16(
    ): array {
        return self::test_crc("crc16");
    }

    public static function test_crc24(
    ): array {
        return self::test_crc("crc24");
    }

    public static function test_crc32(
    ): array {
        return self::test_crc("crc32");
    }

    public static function test_crc64(
    ): array {
        return self::test_crc("crc64");
    }

    private static function test_crc(
        $prefix
    ): array {
        $reflect = new \ReflectionClass(get_called_class());
        $methods = $reflect->getMethods(\ReflectionMethod::IS_PUBLIC);
        $results = array();

        foreach ($methods as $method) {
            $name = $method->getShortName();

            if (!str_starts_with($name, $prefix."_"))
                continue;

            $value = self::$name(self::CRC_CHECK_DATA);
            $check = constant('self::'.strtoupper($name).'_CHECK');

            if (is_string($check))
                self::unpack_uint64($check);

            $results[] = array(
                "method" => $name,
                "calculated" => $value,
                "check" => $check
            );

            if ($value !== $check)
                throw new \UnexpectedValueException(
                    "CRC check value mismatch: ".$name."()"
                );
        }

        return $results;
    }

    private static function reflect_bits(
        &$num,
        $width
    ): void {
        $ref = 0;

        for ($i = 0; $i < $width; $i++) {
            $bit = ($num >> $i) & 0b1;
            $bit = ($bit << (($width - 1) - $i));
            $ref = $ref | $bit;
        }

        $num = $ref;
    }

    /**
     * See: https://bugs.php.net/bug.php?id=76098
     */
    private static function unpack_uint64(
        &$num
    ): void {
        $int = unpack('J', pack("H*", $num));
        $num = $int[1];
    }
}
