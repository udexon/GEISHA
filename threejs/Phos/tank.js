import * as THREE from './resources/threejs/r119/build/three.module.js';

function main() {
  const canvas = document.querySelector('#c');
  const renderer = new THREE.WebGLRenderer({canvas: canvas});
  renderer.setClearColor(0xAAAAAA);
  renderer.shadowMap.enabled = true;

  function makeCamera(fov = 40) {
    const aspect = 2;  // the canvas default
    const zNear = 0.1;
    const zFar = 1000;
    return new THREE.PerspectiveCamera(fov, aspect, zNear, zFar);
  }
  const camera = makeCamera();
  camera.position.set(8, 4, 10).multiplyScalar(3);
  camera.lookAt(0, 0, 0);

  const scene = new THREE.Scene();

  {
    const light = new THREE.DirectionalLight(0xffffff, 1);
    light.position.set(0, 20, 0);
    scene.add(light);
    light.castShadow = true;
    light.shadow.mapSize.width = 2048;
    light.shadow.mapSize.height = 2048;

    const d = 50;
    light.shadow.camera.left = -d;
    light.shadow.camera.right = d;
    light.shadow.camera.top = d;
    light.shadow.camera.bottom = -d;
    light.shadow.camera.near = 1;
    light.shadow.camera.far = 50;
    light.shadow.bias = 0.001;
  }

  {
    const light = new THREE.DirectionalLight(0xffffff, 1);
    light.position.set(1, 2, 4);
    scene.add(light);
  }

  const groundGeometry = new THREE.PlaneBufferGeometry(50, 50);
  const groundMaterial = new THREE.MeshPhongMaterial({color: 0xCC8866});
  const groundMesh = new THREE.Mesh(groundGeometry, groundMaterial);
  groundMesh.rotation.x = Math.PI * -.5;
  groundMesh.receiveShadow = true;
  scene.add(groundMesh);

  const carWidth = 4;
  const carHeight = 1;
  const carLength = 8;


// We dont need to change all code to Phos
// only use Phos to add new objects, 
// with more copact RPN

// instead of new variable tank
// add object to array, with name as key

// add tank 1 with Phos ??



  const tank = new THREE.Object3D();
  scene.add(tank);

  const bodyGeometry = new THREE.BoxBufferGeometry(carWidth, carHeight, carLength);
  const bodyMaterial = new THREE.MeshPhongMaterial({color: 0x6688AA});
  const bodyMesh = new THREE.Mesh(bodyGeometry, bodyMaterial);
  bodyMesh.position.y = 1.4;
  bodyMesh.castShadow = true;
  tank.add(bodyMesh);
  
  
  const tank1 = new THREE.Object3D();
  scene.add(tank1);
  
  f_tank(tank1, carWidth, carHeight, carLength)

  const tankCameraFov = 75;
  const tankCamera = makeCamera(tankCameraFov);
  tankCamera.position.y = 3;
  tankCamera.position.z = -6;
  tankCamera.rotation.y = Math.PI;
  bodyMesh.add(tankCamera);

  const wheelRadius = 1;
  const wheelThickness = .5;
  const wheelSegments = 6;
  const wheelGeometry = new THREE.CylinderBufferGeometry(
      wheelRadius,     // top radius
      wheelRadius,     // bottom radius
      wheelThickness,  // height of cylinder
      wheelSegments);
  const wheelMaterial = new THREE.MeshPhongMaterial({color: 0x888888});
  const wheelPositions = [
    [-carWidth / 2 - wheelThickness / 2, -carHeight / 2,  carLength / 3],
    [ carWidth / 2 + wheelThickness / 2, -carHeight / 2,  carLength / 3],
    [-carWidth / 2 - wheelThickness / 2, -carHeight / 2, 0],
    [ carWidth / 2 + wheelThickness / 2, -carHeight / 2, 0],
    [-carWidth / 2 - wheelThickness / 2, -carHeight / 2, -carLength / 3],
    [ carWidth / 2 + wheelThickness / 2, -carHeight / 2, -carLength / 3],
  ];
  const wheelMeshes = wheelPositions.map((position) => {
    const mesh = new THREE.Mesh(wheelGeometry, wheelMaterial);
    mesh.position.set(...position);
    mesh.rotation.z = Math.PI * .5;
    mesh.castShadow = true;
    bodyMesh.add(mesh);
    return mesh;
  });

  const domeRadius = 2;
  const domeWidthSubdivisions = 12;
  const domeHeightSubdivisions = 12;
  const domePhiStart = 0;
  const domePhiEnd = Math.PI * 2;
  const domeThetaStart = 0;
  const domeThetaEnd = Math.PI * .5;
  const domeGeometry = new THREE.SphereBufferGeometry(
    domeRadius, domeWidthSubdivisions, domeHeightSubdivisions,
    domePhiStart, domePhiEnd, domeThetaStart, domeThetaEnd);
  const domeMesh = new THREE.Mesh(domeGeometry, bodyMaterial);
  domeMesh.castShadow = true;
  bodyMesh.add(domeMesh);
  domeMesh.position.y = .5;

  const turretWidth = .1;
  const turretHeight = .1;
  const turretLength = carLength * .75 * .2;
  const turretGeometry = new THREE.BoxBufferGeometry(
      turretWidth, turretHeight, turretLength);
  const turretMesh = new THREE.Mesh(turretGeometry, bodyMaterial);
  const turretPivot = new THREE.Object3D();
  turretMesh.castShadow = true;
  turretPivot.scale.set(5, 5, 5);
  turretPivot.position.y = .5;
  turretMesh.position.z = turretLength * .5;
  turretPivot.add(turretMesh);
  bodyMesh.add(turretPivot);

  const turretCamera = makeCamera();
  turretCamera.position.y = .75 * .2;
  turretMesh.add(turretCamera);

  const targetGeometry = new THREE.SphereBufferGeometry(.5, 6, 3);
  const targetMaterial = new THREE.MeshPhongMaterial({color: 0x00FF00, flatShading: true});
  const targetMesh = new THREE.Mesh(targetGeometry, targetMaterial);
  const targetOrbit = new THREE.Object3D();
  const targetElevation = new THREE.Object3D();
  const targetBob = new THREE.Object3D();
  targetMesh.castShadow = true;
  scene.add(targetOrbit);
  targetOrbit.add(targetElevation);
  targetElevation.position.z = carLength * 2;
  targetElevation.position.y = 8;
  targetElevation.add(targetBob);
  targetBob.add(targetMesh);

  const targetCamera = makeCamera();
  const targetCameraPivot = new THREE.Object3D();
  targetCamera.position.y = 1;
  targetCamera.position.z = -2;
  targetCamera.rotation.y = Math.PI;
  targetBob.add(targetCameraPivot);
  targetCameraPivot.add(targetCamera);

  const target = {}
  f_target(scene, target, carLength)


  // Create a sine-like wave
  const curve = new THREE.SplineCurve( [
    new THREE.Vector2( -10, 0 ),
    new THREE.Vector2( -5, 5 ),
    new THREE.Vector2( 0, 0 ),
    new THREE.Vector2( 5, -5 ),
    new THREE.Vector2( 10, 0 ),
    new THREE.Vector2( 5, 10 ),
    new THREE.Vector2( -5, 10 ),
    new THREE.Vector2( -10, -10 ),
    new THREE.Vector2( -15, -8 ),
    new THREE.Vector2( -10, 0 ),
  ] );

  const points = curve.getPoints( 50 );
  const geometry = new THREE.BufferGeometry().setFromPoints( points );
  const material = new THREE.LineBasicMaterial( { color : 0xff0000 } );
  const splineObject = new THREE.Line( geometry, material );
  splineObject.rotation.x = Math.PI * .5;
  splineObject.position.y = 0.05;
  scene.add(splineObject);

  function resizeRendererToDisplaySize(renderer) {
    const canvas = renderer.domElement;
    const width = canvas.clientWidth;
    const height = canvas.clientHeight;
    const needResize = canvas.width !== width || canvas.height !== height;
    if (needResize) {
      renderer.setSize(width, height, false);
    }
    return needResize;
  }

  const targetPosition = new THREE.Vector3();
  const tankPosition = new THREE.Vector2();
  const tankTarget = new THREE.Vector2();

  const cameras = [
    { cam: camera, desc: 'detached camera', },
    { cam: turretCamera, desc: 'on turret looking at target', },
    { cam: targetCamera, desc: 'near target looking at tank', },
    { cam: tankCamera, desc: 'above back of tank', },
  ];

  const infoElem = document.querySelector('#info');

  function render(time) {
    time *= 0.001;

    if (resizeRendererToDisplaySize(renderer)) {
      const canvas = renderer.domElement;
      cameras.forEach((cameraInfo) => {
        const camera = cameraInfo.cam;
        camera.aspect = canvas.clientWidth / canvas.clientHeight;
        camera.updateProjectionMatrix();
      });
    }

    // move target
    targetOrbit.rotation.y = time * .27;
    targetBob.position.y = Math.sin(time * 2) * 4;
    targetMesh.rotation.x = time * 7;
    targetMesh.rotation.y = time * 13;

    f_move(target, time + 0.5)

    targetMaterial.emissive.setHSL(time * 10 % 1, 1, .25);
    targetMaterial.color.setHSL(time * 10 % 1, 1, .25);

    // move tank
    const tankTime = time * .05;
    curve.getPointAt(tankTime % 1, tankPosition);
    curve.getPointAt((tankTime + 0.01) % 1, tankTarget);
    tank.position.set(tankPosition.x, 0, tankPosition.y);
    tank.lookAt(tankTarget.x, 0, tankTarget.y);
    
    
    f_move_tank(time - 2, tank1, curve, tankPosition, tankTarget)

    // face turret at target
    targetMesh.getWorldPosition(targetPosition);
    turretPivot.lookAt(targetPosition);

    // make the turretCamera look at target
    turretCamera.lookAt(targetPosition);

    // make the targetCameraPivot look at the at the tank
    tank.getWorldPosition(targetPosition);
    targetCameraPivot.lookAt(targetPosition);

    wheelMeshes.forEach((obj) => {
      obj.rotation.x = time * 3;
    });

    // const camera = cameras[time * .25 % cameras.length | 0];
    const camera = cameras[0];
    infoElem.textContent = camera.desc;

    renderer.render(scene, camera.cam);

    requestAnimationFrame(render);
  }

  requestAnimationFrame(render);
}

main();

function f_move(target, time)
{
    target.Orbit.rotation.y = time * .27;
    target.Bob.position.y = Math.sin(time * 2) * 4;
    target.Mesh.rotation.x = time * 7;
    target.Mesh.rotation.y = time * 13;
}

  function makeCamera(fov = 40) {
    const aspect = 2;  // the canvas default
    const zNear = 0.1;
    const zFar = 1000;
    return new THREE.PerspectiveCamera(fov, aspect, zNear, zFar);
  }


function f_target(scene, target, carLength)
{
  // const target = {};
  target.Geometry = new THREE.SphereBufferGeometry(.5, 6, 3);
  target.Material = new THREE.MeshPhongMaterial({color: 0x00FF00, flatShading: true});
  target.Mesh = new THREE.Mesh(target.Geometry, target.Material);
  target.Orbit = new THREE.Object3D();
  target.Elevation = new THREE.Object3D();
  target.Bob = new THREE.Object3D();
  target.Mesh.castShadow = true;
  
  scene.add(target.Orbit);
  
  target.Orbit.add(target.Elevation);
  
  target.Elevation.position.z = carLength * 2;
  target.Elevation.position.y = 8;
  target.Elevation.add(target.Bob);
  
  target.Bob.add(target.Mesh);

  target.Camera = makeCamera();
  target.CameraPivot = new THREE.Object3D();
  target.Camera.position.y = 1;
  target.Camera.position.z = -2;
  target.Camera.rotation.y = Math.PI;
  target.Bob.add(target.CameraPivot);
  target.CameraPivot.add(target.Camera);

}

function f_move_tank(time, tank, curve, tankPosition, tankTarget)
{
    if (time<0) time=0;
    // move tank
    const tankTime = time * .05;
    curve.getPointAt(tankTime % 1, tankPosition);
    curve.getPointAt((tankTime + 0.01) % 1, tankTarget);
    tank.position.set(tankPosition.x, 0, tankPosition.y);
    tank.lookAt(tankTarget.x, 0, tankTarget.y);
}

// can start adding objects LIVE in browser console now?
// { car: [ W, H, L ] } { mat: {color: ....} } // can check obj key, replace default values  
// export function f_tank(tank, carWidth, carHeight, carLength)
function f_tank(tank, carWidth, carHeight, carLength)
{
  const bodyGeometry = new THREE.BoxBufferGeometry(carWidth, carHeight, carLength);
  const bodyMaterial = new THREE.MeshPhongMaterial({color: 0x6688AA});
  const bodyMesh = new THREE.Mesh(bodyGeometry, bodyMaterial);
  bodyMesh.position.y = 1.4;
  bodyMesh.castShadow = true;
  tank.add(bodyMesh);
}

