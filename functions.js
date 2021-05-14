var web3 = new Web3();
var global_keystore;

var clipboard = new ClipboardJS('.btn-clipboard');

clipboard.on('success', function(e) {
    e.clearSelection();
});

clipboard.on('error', function(e) {
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
});

function setWeb3Provider(keystore) {
  var web3Provider = new HookedWeb3Provider({
    host: "https://ropsten.infura.io/v3/7a8fad4bf24d43c4bf567d30da2cd05e",
    transaction_signer: keystore
  });

  web3.setProvider(web3Provider);
}

function setProvider(index) {
  if(index === 0) {
    document.getElementById("providerBtn").innerText = 'MainNet';
  } else if(index === 1) {
    document.getElementById("providerBtn").innerText = 'TestNet';
  }

}

function newAddresses(password) {
  if (password == '') {
    password = prompt('Enter password to retrieve addresses', 'Password');
  }

  var numAddr = 1;

  global_keystore.keyFromPassword(password, function (err, pwDerivedKey) {
    global_keystore.generateNewAddress(pwDerivedKey, numAddr);

    var addresses = global_keystore.getAddresses();
    document.getElementById('accountAddress').value = '';
    document.getElementById('functionCaller').value = '';
    document.getElementById('accountAddress').value = addresses[0];
    document.getElementById('functionCaller').value = addresses[0];
    store.set('user', { name: global_keystore.serialize()})
    getBalances();
  });
}

function getBalances() {
  var addresses = global_keystore.getAddresses();
  document.getElementById('addr').innerHTML = 'Retrieving addresses...';

  async.map(addresses, web3.eth.getBalance, function (err, balances) {
    async.map(addresses, web3.eth.getTransactionCount, function (err, nonces) {
      document.getElementById('addr').innerHTML = '';
        document.getElementById('addr').innerHTML += '<li class="list-group-item form-control">' + addresses[0] + ' (Bal: ' + (balances[0] / 1.0e18) + ' ETH, Nonce: ' + nonces[0] + ')' + '</li>';
    });
  });
}

function setSeed() {
  var password = prompt('Enter Password to encrypt your seed', 'Password');
  if (password) {
    lightwallet.keystore.createVault({
      password: password,
      seedPhrase: document.getElementById('seed').value,
      //random salt
      hdPathString: 'm/0\'/0\'/0\''
    }, function (err, ks) {
      global_keystore = ks;

      document.getElementById('seed').value = '';

      newAddresses(password);
      setWeb3Provider(global_keystore);

      getBalances();
    });
  }
}

function newWallet() {
  var extraEntropy = document.getElementById('userEntropy').value;
  document.getElementById('userEntropy').value = '';
  var randomSeed = lightwallet.keystore.generateRandomSeed(extraEntropy);

  var infoString = 'Your new wallet seed is: "' + randomSeed +
    '". Please write it down on paper or in a password manager, you will need it to access your wallet. Do not let anyone see this seed or they can take your Ether. ' +
    'Please enter a password to encrypt your seed while in the browser.';
  var password = prompt(infoString, 'Password');
  if (password) {
    lightwallet.keystore.createVault({
      password: password,
      seedPhrase: randomSeed,
      //random salt
      hdPathString: 'm/0\'/0\'/0\''
    }, function (err, ks) {
      global_keystore = ks;
      newAddresses(password);
      setWeb3Provider(global_keystore);
      getBalances();
    });
  }
}

function showSeed() {
  var password = prompt('Enter password to show your seed. Do not let anyone else see your seed.', 'Password');
  if (password) {
    global_keystore.keyFromPassword(password, function (err, pwDerivedKey) {
      var seed = global_keystore.getSeed(pwDerivedKey);
      alert('Your seed is: "' + seed + '". Please write it down.');
    });
  }
}


function exportPrivateKey() {
  var password = prompt('Enter password to show your seed. Do not let anyone else see your seed.', 'Password');

  if (password) {
    global_keystore.keyFromPassword(password, function (err, pwDerivedKey) {
      let address = document.getElementById('accountAddress').value
      var privkey = global_keystore.exportPrivateKey(address, pwDerivedKey);
      alert('Your private key is: ' + privkey);
    });
  }
}

function sendEth() {
  var fromAddr = document.getElementById('accountAddress').value;
  var toAddr = document.getElementById('sendTo').value;
  var valueEth = document.getElementById('sendValueAmount').value;
  var value = parseFloat(valueEth) * 1.0e18;
  web3.eth.getGasPrice(function (err, result) {
    console.log('error: ' + err);
    console.log('gasprice: ' + result);
    web3.eth.estimateGas({
    to: toAddr,
    }, function(err1, result1){
      console.log('error1: ' + err1);
      console.log('gas: ' + result1);
      web3.eth.sendTransaction({
        from: fromAddr,
        to: toAddr,
        value: value,
        gasPrice: result,
        gas: result1
      }, function (err2, txhash) {
        console.log('error2: ' + err2);
        console.log('txhash: ' + txhash);
      })
    })
  });
}

function functionCall() {
  var fromAddr = document.getElementById('functionCaller').value;
  var contractAddr = document.getElementById('contractAddr').value;
  var abi = JSON.parse(document.getElementById('contractAbi').value);
  var contract = web3.eth.contract(abi).at(contractAddr);
  var functionName = document.getElementById('functionName').value;
  var args = JSON.parse('[' + document.getElementById('functionArgs').value + ']');
  var valueEth = document.getElementById('sendValueAmount').value;
  var value = parseFloat(valueEth) * 1.0e18;
  var gasPrice = 50000000000;
  var gas = 4541592;

  args.push({ from: fromAddr, value: value, gasPrice: gasPrice, gas: gas });

  var callback = function (err, txhash) {
    console.log('error: ' + err);
    console.log('txhash: ' + txhash);
  };

  args.push(callback);
  contract[functionName].apply(this, args);
}

function init() {
  if (store.get('user')) {
    let ks = store.get('user').name
    global_keystore = lightwallet.keystore.deserialize(ks);
    var addresses = global_keystore.getAddresses();
    document.getElementById('accountAddress').value = '';
    document.getElementById('functionCaller').value = '';
    document.getElementById('accountAddress').value = addresses[0];
    document.getElementById('functionCaller').value = addresses[0];
    setWeb3Provider(global_keystore);
    getBalances();
  }
}

window.onload = init();