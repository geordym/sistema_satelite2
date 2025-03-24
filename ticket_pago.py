import usb.core
import usb.util

# Buscar el dispositivo en el puerto USB001
port_name = "USB001"  # Nombre del puerto USB donde está conectada la impresora

# Buscar todos los dispositivos USB conectados
dev = usb.core.find(find_all=True)

# Recorremos todos los dispositivos para encontrar el que está conectado al puerto USB001
found = False
for device in dev:
    # Obtener la descripción del puerto
    port = device.get_port()

    # Si el puerto coincide con USB001, obtenemos el VID y PID
    if port == port_name:
        vid = hex(device.idVendor)  # ID del fabricante
        pid = hex(device.idProduct)  # ID del producto
        print(f"Dispositivo conectado al puerto {port_name}: VID={vid}, PID={pid}")
        found = True
        break

if not found:
    print(f"No se encontró dispositivo en el puerto {port_name}.")
