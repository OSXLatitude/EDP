IntelE1000e.kext

Based on Intel82566MM.kext code from googlecode (Guijin Ding) and Intel Linux E1000e driver code.
For copyrights, see individual source files and Intel's COPYING file included in this package.  
(For Intel driver version information, see the version field in Get Info on the kext.)  

Install as you would any special kext, in the S/L/E directory.  
(If putting in the /Extra/Extensions directory instead of S/L/E, 
you'll also need to copy IONetworking.kext from S/L/E to /Extra/Extensions.)

This kext is intended to work with the following devices.  
(Although it has only been tested with 10EA and only briefly, at that.)

Intel Internal name                   DevID     Intel Product name
------------------------------------  --------  -------------------------------------------------
E1000_DEV_ID_82571EB_COPPER           0x105E	82571EB Gigabit Ethernet Controller
E1000_DEV_ID_82571EB_FIBER            0x105F	82571EB Gigabit Ethernet Controller
E1000_DEV_ID_82571EB_SERDES           0x1060	82571EB Gigabit Ethernet Controller
E1000_DEV_ID_82571EB_SERDES_DUAL      0x10D9	82571EB Dual Port Gigabit Mezzanine Adapter
E1000_DEV_ID_82571EB_SERDES_QUAD      0x10DA	82571EB Quad Port Gigabit Mezzanine Adapter
E1000_DEV_ID_82571EB_QUAD_COPPER      0x10A4	82571EB Gigabit Ethernet Controller
E1000_DEV_ID_82571PT_QUAD_COPPER      0x10D5	82571PT Gigabit PT Quad Port Server ExpressModule
E1000_DEV_ID_82571EB_QUAD_FIBER       0x10A5	82571EB Gigabit Ethernet Controller (Fiber)
E1000_DEV_ID_82571EB_QUAD_COPPER_LP   0x10BC	82571EB Gigabit Ethernet Controller (Copper)
E1000_DEV_ID_82572EI_COPPER           0x107D	82572EI Gigabit Ethernet Controller (Copper)
E1000_DEV_ID_82572EI_FIBER            0x107E	82572EI Gigabit Ethernet Controller (Fiber)
E1000_DEV_ID_82572EI_SERDES           0x107F	82572EI Gigabit Ethernet Controller
E1000_DEV_ID_82572EI                  0x10B9	82572EI Gigabit Ethernet Controller (Copper)
E1000_DEV_ID_82573E                   0x108B	82573V Gigabit Ethernet Controller (Copper)
E1000_DEV_ID_82573E_IAMT              0x108C	82573E Gigabit Ethernet Controller (Copper)
E1000_DEV_ID_82573L                   0x109A	82573L Gigabit Ethernet Controller
E1000_DEV_ID_82574L                   0x10D3	82574L Gigabit Network Connection
E1000_DEV_ID_82574LA                  0x10F6	82574L Gigabit Network Connection
E1000_DEV_ID_82583V                   0x150C	82583V Gigabit Network Connection
E1000_DEV_ID_80003ES2LAN_COPPER_DPT   0x1096	80003ES2LAN Gigabit Ethernet Controller (Copper)
E1000_DEV_ID_80003ES2LAN_SERDES_DPT   0x1098	80003ES2LAN Gigabit Ethernet Controller (Serdes)
E1000_DEV_ID_80003ES2LAN_COPPER_SPT   0x10BA	80003ES2LAN Gigabit Ethernet Controller (Copper)
E1000_DEV_ID_80003ES2LAN_SERDES_SPT   0x10BB	80003ES2LAN Gigabit Ethernet Controller (Serdes)
E1000_DEV_ID_ICH8_82567V_3            0x1501	82567V-3 Gigabit Network Connection
E1000_DEV_ID_ICH8_IGP_M_AMT           0x1049	82566MM Gigabit Network Connection
E1000_DEV_ID_ICH8_IGP_AMT             0x104A	82566DM Gigabit Network Connection
E1000_DEV_ID_ICH8_IGP_C               0x104B	82566DC Gigabit Network Connection
E1000_DEV_ID_ICH8_IFE                 0x104C	82562V 10/100 Network Connection
E1000_DEV_ID_ICH8_IFE_GT              0x10C4	82562GT 10/100 Network Connection
E1000_DEV_ID_ICH8_IFE_G               0x10C5	82562G 10/100 Network Connection
E1000_DEV_ID_ICH8_IGP_M               0x104D	82566MC Gigabit Network Connection
E1000_DEV_ID_ICH9_IGP_M               0x10BF	82567LF Gigabit Network Connection
E1000_DEV_ID_ICH9_IGP_M_AMT           0x10F5	82567LM Gigabit Network Connection
E1000_DEV_ID_ICH9_IGP_M_V             0x10CB	82567V Gigabit Network Connection
E1000_DEV_ID_ICH9_IGP_AMT             0x10BD	82566DM-2 Gigabit Network Connection
E1000_DEV_ID_ICH9_BM                  0x10E5	82567LM-4 Gigabit Network Connection
E1000_DEV_ID_ICH9_IGP_C               0x294C	82566DC-2 Gigabit Network Connection
E1000_DEV_ID_ICH9_IFE                 0x10C0	82562V-2 10/100 Network Connection
E1000_DEV_ID_ICH9_IFE_GT              0x10C3	82562GT-2 10/100 Network Connection
E1000_DEV_ID_ICH9_IFE_G               0x10C2	82562G-2 10/100 Network Connection
E1000_DEV_ID_ICH10_R_BM_LM            0x10CC	82567LM-2 Gigabit Network Connection
E1000_DEV_ID_ICH10_R_BM_LF            0x10CD	82567LF-2 Gigabit Network Connection
E1000_DEV_ID_ICH10_R_BM_V             0x10CE	82567V-2 Gigabit Network Connection
E1000_DEV_ID_ICH10_D_BM_LM            0x10DE	82567LM-3 Gigabit Network Connection
E1000_DEV_ID_ICH10_D_BM_LF            0x10DF	82567LF-3 Gigabit Network Connection
E1000_DEV_ID_PCH_M_HV_LM              0x10EA	82577LM Gigabit Network Connection
E1000_DEV_ID_PCH_M_HV_LC              0x10EB	82577LC Gigabit Network Connection
E1000_DEV_ID_PCH_D_HV_DM              0x10EF	82578DM Gigabit Network Connection
E1000_DEV_ID_PCH_D_HV_DC              0x10F0	82578DC Gigabit Network Connection

Internal names from the hw.h file in the code; product names from http://cateee.net/lkddb/web-lkddb/E1000E.html
