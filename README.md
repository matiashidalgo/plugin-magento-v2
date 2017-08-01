<a name="inicio"></a>
Magento- módulo Decidir (v1.7.x a 1.9.x)
============

Plug in para la integración con gateway de pago <strong>Decidir</strong>
- [Consideraciones Generales](#consideracionesgenerales)
- [Instalación](#instalacion)
- [Configuración](#configuracion)
  - [Configuración plug in](#confplugin)
  - [Nuevas tablas, columnas y atributos](#tca)
- [Prevencion de Fraude](#cybersource)
  - [Consideraciones generales](#cons_generales)
  - [Consideraciones para vertical retail](#cons_retail)
- [Características](#features)
  - [Devoluciones](#devoluciones)
- [Tablas de referencia](#tablas)
- [Versiones disponibles](#availableversions)

<a name="consideracionesgenerales"></a>
## Consideraciones Generales
El plug in de pagos de <strong>Decidir</strong>, provee a las tiendas Magento de un nuevo m&eacute;todo de pago, integrando la tienda al gateway de pago.
La versión de este plug in esta testeada en PHP 5.3 en adelante y MAGENTO 1.7 a 1.9

<a name="instalacion"></a>
## Instalación
1. Descomprimir el archivo magento-plugin-master.zip.
2. Copiar carpeta 'app', 'js', 'skin' y 'lib' al root de magento con los mismos nombres.
3. Ir a  System->Cache Managment y refrescar el cache.
4. Luego ir a 'System->Configuration , luego en el menu lateral sales->Payment Methods' y configurar desde la pestaña de <strong>Decidir 2</strong>.

Observaci&oacute;n:
Descomentar: <em>extension=php_curl.dll</em>, <em>extension=php_soap.dll</em> y <em>extension=php_openssl.dll</em> del php.ini, ya que para la conexión al gateway se utiliza la clase <em>SoapClient</em> del API de PHP.
<br />
[<sub>Volver a inicio</sub>](#inicio)

<a name="configuracion"></a>
## Configuración

<a name="confplugin"></a>
#### Configuración plug in
Para llegar al menu de configuración ir a: <em>System->Configuration</em> y seleccionar Payment Methods en el menú izquierdo. Entre los medios de pago aparecerá una solapa con el nombre <strong>Decidir 2</strong>. El Plug-in esta separado en configuarción general y  sub-menues.

##### Menú principal
1. Habilitar/Deshabilitar el módulo.
2. Ingresar public y private api key provistas Decidir.
3. Seleccionar el ambiente en el cuál operar.
4. Elegir los estados de la orden para el circuito de pago.

### Alta de planes de pago:
Para dar de alta modificar o eliminar planes, medios de pago o entidades financieras se dispone el menú **Decidir**, con los correspondientes ABMs

Los principales Medios de pagos vendrán precargados, así mismo las principales entidades financieras.

#### Medios de pago:
En el ABM de medios de pago encontramos los siguientes campos:
* Medio de Pago: El nombre con el que se mostrará dicho medio de pago.
* Decidir: El código del medio de pago en Decidir. [(Ver Tabla en documentación del servicio)](https://decidir.gitbooks.io/documentacion/content/Anexos/TablasReferencia/MediosDePago.html)
* Tipo: _Tarjeta_ u _offline_. Por el momento solo está disponible el primer tipo.
* Activo: Flag para activar/desactivar el medio de pago.

#### Entidades financieras:
En el ABM de Entidades Financieras sólo nos encontramos con el nombre a mostrar y el flag de activación.

#### Planes de Pago:
En el caso de los Planes de Pago:
* Tienda: La tienda en la que desea que se muestre la promoción, en caso de que aplique a todas seleccionar _"Admin"_.
* Cupón o Tarjeta: A que tipo de Medio de pago aplica la promoción.
* Tarjeta: El Medio de Pago al que aplica el plan.
* Entidad Financiera: Con que Entidad está disponible el plan.
* Cuotas: Cantidad de cuotas del plan.
* Porcentaje: El interés a aplicar cuando el plan es elegido.
* Nro. de Comercio: Para filtrar los planes por entidad financiera debe solicitarse un filtro de bines a soporte [(Vease documentación)](https://decidir.gitbooks.io/documentacion/content/Promociones/como_configurar_una_promocion.html). Para eso se creará un nuevo ID Site implementando la configuración Consola unificada. Aquí se carga dicho ID Site.
* Nro. de Comercio Test: Idem anterior en el ambiente Sandbox.
* Activo: Flag activación.

#### Coeficientes:
Esta contiene la tabla de coeficientes directos para aplicar con el medio de pago si no hay una promoción que aplique al banco y cantidad de cuotas elegidas por el usuario. Es necesario que el medio se encuentre en esta tabla para que pueda ser mostrado al comprador.

<a name="tca"></a>

#### Nuevas tablas, columnas y atributos
El plug in para lograr las nuevas funcionalidades y su persistencia dentro del framework crear&aacute; nuevas tablas, columnas y atributos:

##### Nuevas Tablas:
1. decidir_banco
2. decidir_plan
3. decidir_tarjeta
4. decidir_interes

[<sub>Volver a inicio</sub>](#inicio)

<a name="cybersource"></a>
## Prevención de Fraude
- [Consideraciones Generales](#cons_generales)
- [Consideraciones para vertical RETAIL](#cons_retail)

<a name="cons_generales"></a>
#### Consideraciones Generales (para todas los verticales, por defecto RETAIL)
El plug in, toma valores est&aacute;ndar del framework para validar los datos del comprador. Principalmente se utiliza una instancia de la clase <em>Mage_Sales_Model_Order</em>.
Para acceder a los datos del comprador se utiliza el metodo getBillingAddress() que devuelve un objeto ya instanciado del cual se usan los siguientes m&eacute;todos:

```php
   $order = new Mage_Sales_Model_Order ();
   $order->load($id);
-- Ciudad de Facturación: $order->getBillingAddress()->getCity();
-- País de facturación: $order->getBillingAddress()->getCountry();
-- Identificador de Usuario: $order->getBillingAddress()->getCustomerId();
-- Email del usuario al que se le emite la factura: $order->getBillingAddress()->getEmail();
-- Nombre de usuario el que se le emite la factura: $order->getBillingAddress()->getFirstname();
-- Apellido del usuario al que se le emite la factura: $order->getBillingAddress()->getLastname();
-- Teléfono del usuario al que se le emite la factura: $order->getBillingAddress()->getTelephone();
-- Provincia de la dirección de facturación: $order->getBillingAddress()->getRegion();
-- Domicilio de facturación: $order->getBillingAddress()->getStreet1();
-- Complemento del domicilio. (piso, departamento): $order->getBillingAddress()->getStreet2();
-- Código postal: $order->getBillingAddress()->getPostcode()
-- Moneda: $order->getBaseCurrencyCode();
-- Total:  $order->getGrandTotal();
-- En caso de pagar con Cupon: $order->getCuponCode();
```
Otros de los modelos utlilizados es <em>Customer</em> del cual a trav&eacute;s  del m&eacute;todo <em>getPasswordHash()</em>, se extrae el password del usuario (comprador) y la tabla <em>sales_flat_invoice_grid</em>, donde se consultan las transacciones facturadas al comprador.
<a name="cons_retail"></a>
#### Consideraciones para vertical RETAIL
Las consideración para el caso de empresas del rubro <strong>RETAIL</strong> son similares a las <em>consideraciones generales</em> con la diferencia de se utiliza el m&eacute;todo getShippingAddress() que devuelve un objeto y del cual se utilizan los siguientes m&eacute;todos;
```php
-- Ciudad de envío de la orden: $order->getShippingAddress()->getCity();
-- País de envío de la orden: $order->getShippingAddress()->getCountry();
-- Mail del destinatario: $order->getShippingAddress()->getEmail();
-- Nombre del destinatario: $order->getShippingAddress()->getFirstname();
-- Apellido del destinatario: $order->getShippingAddress()->getLastname();
-- Número de teléfono del destinatario: $order->getShippingAddress()->getTelephone();
-- Código postal del domicio de envío: $order->getShippingAddress()->getPostcode();
-- Provincia de envío: $order->getShippingAddress()->getRegion();
-- Domicilio de envío: $order->getShippingAddress()->getStreet1();
-- Método de despacho: $order->getShippingDescription();
-- Código de cupón promocional: $order->getCuponCode();
-- Para todo lo referido productos: $order->getItemsCollection();
```
Nota: el valor resultante de $order->getItemsCollection(), se usan como referencias para conseguir informaci&oacute;n del modelo catalog/producto - a través de los métodos <strong>getDescription(), getName(), getSku(), getQtyOrdered(), getPrice()</strong>-.

#### Muy Importante
<strong>Provincias:</strong> uno de los datos requeridos para prevención común a todos los verticales  es el campo provinicia/state tanto del comprador como del lugar de envío, para tal fin el plug in utiliza el valor del campo región de las tablas de la orden (sales_flat_order_address) a través del getRegion() tanto del <em>billingAddress</em> como del <em>shippingAddress</em>. El formato de estos datos deben ser tal cual la tabla de referencia (tabla provincias). Para simplificar la implementación de la tabla en magento se deja para su implementación la clase Decidir\Decidirpago\Model\System\Config\Source\Csprovincias.php, con el formato requerido. Al final de este documento se muestra un script sql que pude ser tomado de refrencia.
<br />

En caso que la tienda decida no implementar este nuevo atributo o que el valor quede vac&iacute;o el plug in mandara al sistema el mismo n&uacute;mero que devuleve el m&eacute;todo $order->getBillingAddress()->getTelephone().
<a name="prevfraudedatosadicionales" ></a>

#### Nuevos Atributos en los productos

<a name="features"></a>
## Características
 - [Devoluciones](#devoluciones)

<a name="devoluciones"></a>
#### Devoluciones
Es posible realizar devoluciones o reembolsos mediante el procedimiento habitual de Magento. Para ello dirigirse a una orden, y mediante el menú seleccionar "Invoices" para poder generar una nota de crédito (credit memo) sobre la factura. Allí deberá hacerse click en el botón "Refund" para que la devolución sea online y procesada por Decidir.</br>

[<sub>Volver a inicio</sub>](#inicio)


<a name="tablas"></a>
## Tablas de Referencia

###### [Provincias](#p)

###### [Script SQL provincias](#sp)

<a name="p"></a>
<p>Provincias</p>
<table>
<tr><th>Provincia</th><th>Código</th></tr>
<tr><td>CABA</td><td>C</td></tr>
<tr><td>Buenos Aires</td><td>B</td></tr>
<tr><td>Catamarca</td><td>K</td></tr>
<tr><td>Chaco</td><td>H</td></tr>
<tr><td>Chubut</td><td>U</td></tr>
<tr><td>Córdoba</td><td>X</td></tr>
<tr><td>Corrientes</td><td>W</td></tr>
<tr><td>Entre Ríos</td><td>E</td></tr>
<tr><td>Formosa</td><td>P</td></tr>
<tr><td>Jujuy</td><td>Y</td></tr>
<tr><td>La Pampa</td><td>L</td></tr>
<tr><td>La Rioja</td><td>F</td></tr>
<tr><td>Mendoza</td><td>M</td></tr>
<tr><td>Misiones</td><td>N</td></tr>
<tr><td>Neuquén</td><td>Q</td></tr>
<tr><td>Río Negro</td><td>R</td></tr>
<tr><td>Salta</td><td>A</td></tr>
<tr><td>San Juan</td><td>J</td></tr>
<tr><td>San Luis</td><td>D</td></tr>
<tr><td>Santa Cruz</td><td>Z</td></tr>
<tr><td>Santa Fe</td><td>S</td></tr>
<tr><td>Santiago del Estero</td><td>G</td></tr>
<tr><td>Tierra del Fuego</td><td>V</td></tr>
<tr><td>Tucumán</td><td>T</td></tr>
</table>
[<sub>Volver a inicio</sub>](#inicio)

<a name="sp"></a>
```sql
INSERT INTO
directory_country_region (region_id, country_id , code, default_name)
VALUES
('4859', 'AR', 'C', 'CABA'),
('486' , 'AR', 'B', 'Buenos Aires'),
('487' , 'AR', 'A', 'Salta'),
('488' , 'AR', 'K', 'Catamarca'),
('489' , 'AR', 'H', 'Chaco'),
('490' , 'AR', 'U', 'Chubut'),
('491' , 'AR', 'X', 'Cordoba'),
('492' , 'AR', 'W', 'Corrientes'),
('493' , 'AR', 'E', 'Entre Rios'),
('494' , 'AR', 'P', 'Formosa'),
('495' , 'AR', 'Y', 'Jujuy'),
('496' , 'AR', 'L', 'La Pampa'),
('497' , 'AR', 'F', 'La Rioja'),
('498' , 'AR', 'M', 'Mendoza'),
('499' , 'AR', 'N', 'Misiones'),
('500' , 'AR', 'Q', 'Neuquen'),
('501' , 'AR', 'R', 'Rio Negro'),
('502' , 'AR', 'J', 'San Juan'),
('503' , 'AR', 'D', 'San Luis'),
('504' , 'AR', 'S', 'Santa Fe'),
('505' , 'AR', 'G', 'Santiago del Estero'),
('506' , 'AR', 'V', 'Tierra del Fuego'),
('507' , 'AR', 'T', 'Tucuman'),
('5071', 'AR', 'Z', 'Santa Cruz');

INSERT INTO
directory_country_region_name (locale, region_id , name)
VALUES
('en_US', '4859', 'CABA'),
('en_US', '486', 'Buenos Aires'),
('en_US', '487', 'Salta'),
('en_US', '488', 'Catamarca'),
('en_US', '489', 'Chaco'),
('en_US', '490', 'Chubut'),
('en_US', '491', 'Cordoba'),
('en_US', '492', 'Corrientes'),
('en_US', '493', 'Entre Rios'),
('en_US', '494', 'Formosa'),
('en_US', '495', 'Jujuy'),
('en_US', '496', 'La Pampa'),
('en_US', '497', 'La Rioja'),
('en_US', '498', 'Mendoza'),
('en_US', '499', 'Misiones'),
('en_US', '500', 'Neuquen'),
('en_US', '501', 'Rio Negro'),
('en_US', '502', 'San Juan'),
('en_US', '503', 'San Luis'),
('en_US', '504', 'Santa Fe'),
('en_US', '505', 'Santiago del Estero'),
('en_US', '506', 'Tierra del Fuego'),
('en_US', '507', 'Tucuman'),
('en_US','5071', 'Santa Cruz');
```

<a name="availableversions"></a>
## Versiones Disponibles
<table>
  <thead>
    <tr>
      <th>Version del Plugin</th>
      <th>Estado</th>
      <th>Versiones Compatibles</th>
    </tr>
  <thead>
  <tbody>
    <tr>
      <td><a href="https://github.com/TodoPago/Plugin-Magento/archive/master.zip">v1.7.x - v1.9.x</a></td>
      <td>Stable (Current version)</td>
      <td>Community Edition 1.6.x - 1.9.x<br />
          Enterprise Edition 1.11.x - 1.14.x
      </td>
    </tr>
  </tbody>
</table>

[<sub>Volver a inicio</sub>](#inicio)
