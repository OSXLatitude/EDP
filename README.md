# EDP (Extra Driver Package)

EDP is a configuration and deployment framework designed to simplify **Hackintosh installation and post-installation setup** on supported laptop hardware.

---

## Overview

EDP (Extra Driver Package) provides a unified solution to manage and configure Hackintosh systems by combining:

- Pre-configured kexts  
- DSDT / SSDT patches  
- System configuration files  
- Model-specific setups  

It was developed as part of the OSXLatitude ecosystem to streamline the process of making unsupported hardware work reliably with macOS.

---

## Key Features

- Model-based configuration system  
- Pre-integrated kext packages  
- Automated setup and deployment scripts  
- Repository of drivers, patches, and fixes  
- Centralized management of Hackintosh configurations  

---

## Architecture

EDP is structured as a modular system:

- **Models** → Device-specific configurations  
- **Kext Packs** → Hardware drivers (audio, network, PS/2, etc.)  
- **DSDT/SSDT** → ACPI patches per device  
- **Tools & Scripts** → Installation and configuration automation  

This allows flexible customization while maintaining a consistent setup process.

---

## Use Case

EDP is used for:

- Post-installation configuration of macOS on laptops  
- Managing hardware compatibility layers  
- Deploying stable configurations across multiple devices  

---

## Technical Details

- Language: Shell scripts, configuration files, plist  
- Platform: macOS (Hackintosh environments)  
- Components:
  - Kernel extensions (kexts)  
  - ACPI patches  
  - Bootloader configurations  

---

## Installation / Usage

EDP is typically used after macOS installation:

1. Download and extract EDP  
2. Run the configuration tool / script  
3. Select your device model  
4. Apply required kexts, patches, and configurations  
5. Reboot  

> Detailed usage depends on system configuration and model support.

---

## Compatibility

- macOS (Hackintosh only)  
- Designed primarily for supported laptop models in the OSXLatitude ecosystem  

> Compatibility depends on available model configurations and hardware support.

---

## Status

⚠️ Legacy project – development has slowed as newer tools and workflows emerged.

---

## Credits

- OSXLatitude community  
- Contributors providing model configurations and testing  
- Hackintosh ecosystem for kexts, patches, and tools  

---

## Disclaimer

This project is intended for educational and experimental purposes.

- Not affiliated with Apple or hardware vendors  
- Use at your own risk  
- Hardware compatibility varies by system  

---

## License

This project is licensed under the **GNU General Public License v2.0 (GPL-2.0)**.

EDP includes components and configurations derived from various open-source projects and community contributions.
